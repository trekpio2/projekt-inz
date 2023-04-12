var data = '{"lightsLevel":24,"temperature":36,"filter":1,"pump":1}';
fetch('http://1.1.1.1', {
  method: 'POST',
  headers: { 'Content-Type': 'application/json' },
  body: JSON.stringify(data)
})
.then(response => response.text())
.then(data => console.log(data))
.catch(error => console.error('Error:', error));
