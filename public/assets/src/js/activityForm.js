document.addEventListener('DOMContentLoaded', ()=>{

    let isPlanned = document.querySelector('#is_planned');
    let startTime = document.querySelector('#start_time');
    let startDate = document.querySelector('#start_date');
    let periodNr = document.querySelector('#period_nr');
    let period = document.querySelector('#period');

    isPlanned.addEventListener('change', ()=>{
        if(isPlanned.checked == true)
        {
            startTime.disabled = false;
            startDate.disabled = false;
            periodNr.disabled = false;
            period.disabled = false;

            startTime.required = true;
            startDate.required = true;
            periodNr.required = true;
            period.required = true;
        }
        else
        {
            startTime.disabled = true;
            startDate.disabled = true;
            periodNr.disabled = true;
            period.disabled = true;

            startTime.required = false;
            startDate.required = false;
            periodNr.required = false;
            period.required = false;
        }
    });
});