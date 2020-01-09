var mysql = require('mysql');
var connection = mysql.createConnection({
  host     : 'localhost',
  port     : '3306',
  user     : 'kiddybuddy_appuser',
  password : 'kiddybuddy_password',
  //socket   : '/Applications/MAMP/tmp/mysql/mysql.sock',
  database : 'kiddybuddy'
});

connection.connect(function(err) {
    if (err){
      console.log(err);
      //throw err;
    } else {
      console.log('DB connected :)');
    }
});

module.exports = connection;