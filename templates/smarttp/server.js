const phpServer = require('php-server');
 
const server = phpServer({
  root: __dirname,
  port: process.env.PORT || 3000,
  hostname: '0.0.0.0',
  directives: {
    display_errors: 1,
    error_reporting: 'E_ALL'
  }
});
 
server.listen(err => {
  if (err) {
    console.error('Error:', err);
    return;
  }
  console.log(`PHP server running on port ${server.port}`);
});
