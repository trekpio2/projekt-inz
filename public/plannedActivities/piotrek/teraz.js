fetch('https://jsonplaceholder.typicode.com/users', {
  method: 'POST',
  headers: {
    'Content-Type': 'application/json'
  },
  body: JSON.stringify({"lightsLevel":12,"temperature":4,"feed":1,"pump":1}),
}).then((response) => {
  console.log(response.status);
  console.log(response);
  fetch('/assets/src/js/LogActivityExecution.php', {
    method: 'POST',
    headers: {
      'Content-Type': 'application/json'
    },
    body: JSON.stringify(),
  })
  .then((response) => {
    if (response.ok) {
      console.log('Timestamp logged successfully!');
    } else {
      throw new Error('Error logging timestamp');
    }
  })
  .catch((error) => {
    console.error('Error logging timestamp:', error);
  });
});