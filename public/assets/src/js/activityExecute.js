let executeBtn = document.querySelector('#executeBtn');
console.log(ip);
console.log(executeData);
console.log(userName);
console.log(activityName);
let logData = {
    'userName': userName,
    'activityName': activityName,
  };

executeBtn.addEventListener('click', () => {
        //request for user's server
        fetch(ip, {
           method: 'POST',
           headers: {
               'Content-Type': 'application/json'
            },
            body: JSON.stringify(executeData),
        }).then((response) => {
            console.log(response.status);
            console.log(response);
            //logging information about execution
            fetch('/public/assets/src/php/LogActivityExecution.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                 },
                body: JSON.stringify(logData),
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
        })

});