let express = require('express');
let session = require('express-session');
let route = express.Router();
let db = require('../database/config');
function calculatetotal(products){
  let totalprice = 0;
  products.forEach(item => {
    totalprice+=(item.qnt*item.price);
  });
  return totalprice.toFixed(2);
}
route.get('/', function(req, res) {
  res.render('home', {title: 'Home'});
});

route.get('/shop', function(req, res) {
  let products;
  db.query("SELECT * FROM products left join categories on categories.id=products.category", function (err, result, fields) {
    if (err) {
      throw err;
    } else {
      res.render('products', {title: 'Shop', products: result});
    }
  });
});

route.get('/product/:product', function(req, res) {
  let products;
  db.query("SELECT * FROM products left join categories on categories.id=products.category where pid='"+req.params.product+"'", function (err, result, fields) {
    if (err) {
      throw err;
    } else {
      res.render('product', {title: 'Product', products: result});
    }
  });
});

route.get('/add-to-cart/:product', function(req, res) {

  let product = req.params.product.split("-")[1];
  let products = [];
  let totalprice = 0;
  if(req.cookies.kiddybuddy_cart) {
    products = req.cookies.kiddybuddy_cart;
  }
  db.query("SELECT * FROM products left join categories on categories.id=products.category where pid='"+product+"'", function (err, result, fields) {
    if (err) {
      console.log(err)
      res.render('page', {title: 'About'});
    } else {
      let flag = 0;
      products.forEach(item => {
        if(item.pid == product) {
          flag = 1;
        }
      });
      //console.log(result);
      if(flag == 0) {
        products.push({
          pid: result[0].pid,
          title: result[0].title,
          name: result[0].name,
          price: result[0].price,
          picture: result[0].picture,
          qnt: 1
        });
      }
      
      //res.send(products);
      res.cookie('kiddybuddy_cart', products, {path:'/'});
      totalprice = calculatetotal(products);
      res.cookie('kiddybuddy_total', totalprice, {path:'/'});
      res.redirect('/cart');
    }
  });
});

route.get('/remove-from-cart/:index', function(req, res) {
  let products = req.cookies.kiddybuddy_cart;
  let totalprice = req.cookies.kiddybuddy_total;
  let index = req.params.index.split("-")[1];
  products.splice(index, 1);
  res.cookie('kiddybuddy_cart', products, {path:'/'});  
  totalprice = calculatetotal(products);
  res.cookie('kiddybuddy_total', totalprice, {path:'/'});
  res.redirect('/cart');
});

route.get('/empty-cart', function(req, res) {
  res.cookie('kiddybuddy_cart', [], {path:'/'});
  res.cookie('kiddybuddy_total', 0, {path:'/'});
  
  res.redirect('/cart');
});

route.get('/cart', function(req, res) {
  let products = [];
  let totalprice = 0;
  if(req.cookies.kiddybuddy_cart) {
    res.render('cart', {title: 'Cart', products: req.cookies.kiddybuddy_cart , totalprice: req.cookies.kiddybuddy_total});
  } else {
    res.render('cart', {title: 'Cart', products: products, totalprice: totalprice});
  }

});

route.post('/update-cart', function(req, res) {
  let products = req.cookies.kiddybuddy_cart;
  let totalprice = req.cookies.kiddybuddy_total;
  products.forEach(function(product, index) {
    product.qnt = req.body.qnt[index];
  });
  res.clearCookie('kiddybuddy_cart', {path:'/'});
  res.cookie('kiddybuddy_cart', products);
  totalprice = calculatetotal(products);
  res.cookie('kiddybuddy_total', totalprice, {path:'/'});
  res.redirect('/cart');
});

route.post('/place-order', function(req, res) {
  //console.log(req.cookies.kiddybuddy_cart);
  let products = req.cookies.kiddybuddy_cart;
  let totalprice = req.cookies.kiddybuddy_total;
  var sql = "INSERT INTO `order`(`fname`,`lname`,`email`,`phone`,`address`,`city`,`state`,`country`,`totalprice`) VALUES('"+req.body.user.fname+"','"+req.body.user.lname+"','"+req.body.user.email+"','"+req.body.user.phone+"','"+
              req.body.user.address+"','"+req.body.user.city+"','"+req.body.user.state+"','"+req.body.user.country+"',"+totalprice+");"
  db.query(sql, function (err, result, fields) {
    if (err) {
      console.log(err)
      res.redirect('/');
    } else {
      orderid = result.insertId;
      products.forEach(function(product, fields) {
        var sql = "INSERT INTO `orderdetail`(`orderid`,`pid`,`qty`)VALUES( "+orderid+","+product.pid+","+product.qnt+");"
        db.query(sql, function (err, result, fields) {
          if (err) {
            console.log(err)
            res.redirect('/');
          } else {
            orderdetailid = result.insertId;
          }
        });
      });
      res.cookie('kiddybuddy_cart', [], {path:'/'});
      res.cookie('kiddybuddy_total', 0, {path:'/'});
      req.param.orderid = orderid;
      res.redirect('/order');
    }
  });
});
route.get('/checkout', function(req, res) {
  let products = [];
  if(req.cookies.kiddybuddy_cart) {
    res.render('checkout', {title: 'Checkout', products: req.cookies.kiddybuddy_cart, totalprice: req.cookies.kiddybuddy_total});
  } else {
    res.render('checkout', {title: 'Checkout', products: products, totalprice: totalprice});
  }
});
route.get('/order', function(req, res) {
  
    res.render('order', {title: 'Order', orderid : req.param.orderid});

});

route.get(['/about','/contact'], function(req, res) {
  db.query("SELECT * FROM pages where url='"+req.url+"'", function (err, result, fields) {
    let contentdata ='';
    if (err) {
      console.log(err)
      res.redirect('/');
    } else {
      contentdata = result[0].content;
      title = result[0].title;
      }
    res.render('page', {title: title , contentdata : contentdata});
  });
});

module.exports = route;