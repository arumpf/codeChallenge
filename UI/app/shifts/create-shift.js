$(document).ready(function(){
 
    // show html form when 'create shift' button was clicked
    $(document).on('click', '.create-shift-button', function(){
       $.getJSON("http://localhost:8000/api/employee/read.php", function(data){
// build categories option html
// loop through returned list of data
var emps_options_html=`<select name='emp_name' class='form-control'>`;
$.each(data.records, function(key, val){
    emps_options_html+=`<option value='` + val.name + `'>` + val.name + `</option>`;
});
emps_options_html+=`</select>`;
// full shift entry form w/ spot for employee name dropdown
var create_shift_html=`
 
    <!-- schedule button to return to schedule -->
    <div id='reload schedule' class='btn btn-primary pull-right m-b-15px reload-schedule-button'>
        <span class='glyphicon glyphicon-list'></span> Reload Schedule
    </div>

<!-- create shift html form-->
<form id='create-shift-form' action='#' method='post' border='0'>
    <table class='table table-hover table-responsive table-bordered'>
 
        <!-- start date field -->
        <tr>
            <td>Start Start Time</td>
            <td><input type='datetime' name='start_time' class='form-control' title="Please enter in human readable (e.g. 'Feb 20 2019 11:00') format" required /></td>
        </tr>
 
 
        <!-- length field -->
        <tr>
            <td>Length</td>
            <td><input type='number' min = '1' max = '16' name='length' class='form-control' required></td>
        </tr>
 
        <!-- employee select field -->
        <tr>
            <td>Employee</td>
            <td>` + emps_options_html + `</td>
        </tr>
 
        <!-- button to submit form -->
        <tr>
            <td></td>
            <td>
                <button type='submit' class='btn btn-primary'>
                    <span class='glyphicon glyphicon-plus'></span> Create Shift
                </button>
            </td>
        </tr>
 
    </table>
</form>`;

// inject to page
$("#page-content").html(create_shift_html);
 
changePageTitle("New Shift");
 
});
    });
 
    // fires when submitted
$(document).on('submit', '#create-shift-form', function(){
   // get form data
var form_data=JSON.stringify($(this).serializeObject());

// submit form data to api
$.ajax({
    url: "http://localhost:8000/api/shift/create.php",
    type : "POST",
    contentType : 'application/json',
    data : form_data,
    success : function(result) {
        // shift was created, return to schedule
        listAllShifts();
    },
    error: function(xhr, resp, text) {
        // show error to console
        console.log(xhr, resp, text);
    }
});
 
return false;
});
});
