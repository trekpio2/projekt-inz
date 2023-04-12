let executeBtn = document.querySelector('#executeBtn');
console.log(ip);
console.log(executeData);
executeBtn.addEventListener('click', () => {
        //zapytanie do serwera uzytkownika
        fetch(ip, {
           method: 'POST',
           headers: {
               'Content-Type': 'application/json'
            },
            body: JSON.stringify(executeData),
        }).then((response) => {
            console.log(response.status);
            console.log(response);
        })

});