function GetDate(firstdate, years=0) {
    date = (firstdate.getFullYear()+years) + "-";
    if(firstdate.getMonth() < 9){
        date+= "0" + (firstdate.getMonth()+1) + "-";
    }else{
        date+= (firstdate.getMonth()+1) + "-";
    } 
    if(firstdate.getDate() < 9){
        date+= "0" + (firstdate.getDate()+1); 
    } else{
        date+= firstdate.getDate()+1;
    }
    return date;
}
function DateInput() {
    var datecontrol = document.getElementById('firstdate').value;
    var seconddate = document.getElementById('seconddate');
    datecontrol = new Date(datecontrol);
    finaldate = GetDate(datecontrol);
    maxdate = GetDate(datecontrol,1);
    seconddate.setAttribute('min', finaldate);
    seconddate.setAttribute('max', maxdate);
}