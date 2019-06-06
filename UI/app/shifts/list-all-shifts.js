$(document).ready(function(){
 
    // show full schedule on load
    listAllShifts();

// handle manual reloads
$(document).on('click', '.reload-schedule-button', function(){
    listAllShifts();
});
 
});
var isAuth = true; //hook for authentication later, basically enable if current employee role > 1

function listAllShifts(){
$.getJSON("http://localhost:8000/api/shift/read.php", function(data){
var list_shifts_html = ``;
if (isAuth) {
	list_shifts_html +=`    <!-- to launch create shift-->
<div id='create-shift' class='btn btn-primary pull-right m-b-15px create-shift-button'>
        <span class='glyphicon glyphicon-plus'></span> New Shift
    </div>`
}
list_shifts_html+=`

<!-- start table -->
<table class='table table-bordered table-hover'>
 
    <!-- creating our table heading -->
    <tr>
        <th >Start Time</th>
        <th>Length (hours)</th>
        <th>Name</th>
    </tr>`;
     
   // loop through returned list of data
   if(data.records){
$.each(data.records, function(key, val) {
 
    // creating new table row per record
    list_shifts_html+=`
        <tr>
 
            <td>` + val.start_time + `</td>
            <td>` + val.length + `</td>
            <td>` + val.emp_name + `</td>
 
        </tr>`;
   });}
 
// end table
list_shifts_html+=`</table>`;

$("#page-content").html(list_shifts_html);

changePageTitle("Full Schedule");



});


}
 

