<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>CRUD</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.0/jquery.min.js"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
</script>
    <script>
        $(document).ready(function(){
            loadData();
            $(document).on("click", "#ajax-save", function () {
                if($.trim($('.name').val()).length == 0){
                    error_name = 'Please enter Name!';
                    $('#error_name').text(error_name);
                }
                else{
                    error_name = '';
                    $('#error_name').text(error_name);
                }
                if($.trim($('.email').val()).length == 0){
                    error_email = 'Please enter Email id!';
                    $('#error_email').text(error_email);
                }
                else{
                    error_email = '';
                    $('#error_email').text(error_email);
                }
                if($.trim($('.phone').val()).length == 0){
                    error_phone = 'Please enter phone number!';
                    $('#error_phone').text(error_phone);
                }
                else{
                    error_phone = '';
                    $('#error_phone').text(error_phone);
                }
                if($.trim($('.city').val()).length == 0){
                    error_city = 'Please enter city!';
                    $('#error_city').text(error_city);
                }
                else{
                    error_city = '';
                    $('#error_city').text(error_city);
                }
                if($.trim($('.age').val()).length == 0){
                    error_age = 'Please enter age!';
                    $('#error_age').text(error_age);
                }
                else{
                    error_age = '';
                    $('#error_age').text(error_age);
                }
                if(error_name != '' || error_phone != '' || error_city != '' ||error_age != ''){
                    return false;
                }
                else{
                    var record = {
                        'name' : $('.name').val(),
                        'email' : $('.email').val(),
                        'phone' : $('.phone').val(),
                        'city' : $('.city').val(),
                        'age' : $('.age').val(),

                    };
                    $.ajax({
                    method: "POST",
                    url: "http://localhost/ci4/Finals/Fadd",
                    data: record,
                    success:function(message){
                        var c = JSON.parse(message);
                        $('#crudModal').modal('hide');
                        $('#crudModal').find('input').val('');
                        loadData();
                        swal({
  title: "Good job!",
  text: c,
  icon: "success",
  button: "Done!",
});
                    }
                    });
                    
                }
            });
function loadData(page) {
    $.ajax({
        method: 'POST',
        url: "http://localhost/ci4/Finals/Fread",
        data: {page_no:page},
        success: function(data) {
            var a = JSON.parse(data); 
            $('.tab_bod').empty();
            $.each(a.view, function(key, val) {
                $('.tab_bod').prepend('<tr>\
                    <td>' + val['id'] + '</td>\
                    <td>' + val['Name'] + '</td>\
                    <td>' + val['Email'] + '</td>\
                    <td>' + val['phone'] + '</td>\
                    <td>' + val['City'] + '</td>\
                    <td>' + val['Age'] + '</td>\
                    <td>\
                        <button class="btn btn-primary updt" data-bs-toggle="modal" data-bs-target="#updateModal">Update</button>\
                        <button class="btn btn-danger del">Delete</button>\
                    </td>\
                </tr>'); 
            });
            $('.pagi').empty();
            for (var i = 1; i <= a.total_link; i++) {
    $('.pagi').append('<button id="' + i + '">' + i + '</button>');
};
            
        }
    });
}
$(document).on('click','.pagi button',function(){
      var page_id = $(this).attr('id');
      loadData(page_id);
    });
    
$('#search_text').keyup(function(){
    var search = $(this).val();
    if(search != ''){
      $.ajax({
        method: "POST",
        url: "http://localhost/ci4/Finals/searchh",
        data: {query:search},
        success: function(data){
          var a = JSON.parse(data);
          $('.res').empty();
          $('.tab_bod').empty();
            $.each(a, function(key, val){
                $('.res').append('<tr>\
                <td>' + val['id'] + '</td>\
                <td>' + val['Name'] + '</td>\
                <td>' + val['Email'] + '</td>\
                <td>' + val['phone'] + '</td>\
                <td>' + val['City'] + '</td>\
                <td>' + val['Age'] + '</td>\
                <td>\
                        <button class="btn btn-primary updt" data-bs-toggle="modal" data-bs-target="#updateModal">Update</button>\
                        <button class="btn btn-danger del">Delete</button>\
                    </td>\
                </tr>'); 
            });
      }
    });
  }
});
$(document).on('click','.updt',function(){
            var Id = $.trim($(this).parent().parent().find('td:eq(0)').text());
            var namE = $.trim($(this).parent().parent().find('td:eq(1)').text());
            var emaiL = $.trim($(this).parent().parent().find('td:eq(2)').text());
            var phonE = $.trim($(this).parent().parent().find('td:eq(3)').text());
            var citY = $.trim($(this).parent().parent().find('td:eq(4)').text());
            var agE = $.trim($(this).parent().parent().find('td:eq(5)').text());
            modalid.value = Id;
            modalname.value = namE;
            modalemail.value = emaiL;
            modalphone.value = phonE;
            modalcity.value = citY;
            modalage.value = agE;
        });
        $('#ajax-update').click(function(){
            var data = {
            'id':$('#modalid').val(),
            'name':$('#modalname').val(),
            'email':$('#modalemail').val(),
            'city':$('#modalcity').val(),
            'age':$('#modalage').val(),
            'phone':$('#modalphone').val(),
            }
            $.ajax({
                method: "POST",
                url: "http://localhost/ci4/Finals/Fupdate",
                data: data,
                success: function(message){
                    var jsonData = JSON.parse(message);
                    $('#updateModal').find('input').val('');
                    $("#updateModal").modal('hide');
                    swal("Good job!",jsonData, "success");
                    loadData(1);
                    
                }
            });
        });
        $(document).on('click','.del',function(){
            var id = $.trim($(this).parent().parent().find('td:eq(0)').text())
            var DATA = {'id': $.trim($(this).parent().parent().find('td:eq(0)').text())}
            var row = $(this).parent().parent();
            $.ajax({
                method: 'POST',
                url: "http://localhost/ci4/Finals/Fdel",
                data: DATA,
                success: function(data){
                    var Data = JSON.parse(data);
                    if(id == Data.uniid){
                        swal({
  title: "Are you sure?",
  text: "Once deleted, you will not be able to recover!",
  icon: "warning",
  buttons: true,
  dangerMode: true,
})
.then((willDelete) => {
  if (willDelete) {
    swal("Deleted Successfully!", {
      icon: "success",
    });
  } else {
    swal("Your Data is not deleted");
  }
});
                        loadData(1);
                    }

                }
            });
        });
    });
</script>
</head>
<body>
<center><h1>Crud Application</h1><center>
<br>
<!-- Modal -->
<div class="modal fade" id="updateModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Update Data</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form method="POST">
            <input class="form-control" id="modalid" disabled hidden>
            <label class="form-label">Name:</label>
            <input type="text" class="form-control" id="modalname" name="name">
            <label class="form-label">Email:</label>
            <input type="email" class="form-control" id="modalemail" name="email">
            <label class="form-label">Phone Number:</label> 
            <input type="number" class="form-control" id="modalphone" name="phone">
            <label class="form-label">City:</label> 
            <input type="text" class="form-control" id="modalcity" name="city">
            <label class="form-label">Age:</label>
            <input type="number" class="form-control" id="modalage" name="age">
</form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id='ajax-update'>Save changes</button>
      </div>
    </div>
  </div>
</div>
<div class="modal fade" id="crudModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Add Data</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form method = 'POST'>
            <input class="form-control id" hidden disbaled>
            <label class="form-label">Name:</label> <span id="error_name" class="text-danger ms-3"></span>
            <input type="text" class="form-control name" name="name">
            <label class="form-label">Email:</label> <span id="error_email" class="text-danger ms-3"></span>
            <input type="email" class="form-control email" name="email">
            <label class="form-label">Phone Number:</label> <span id="error_phone" class="text-danger ms-3"></span>
            <input type="number" class="form-control phone" name="phone">
            <label class="form-label">City:</label> <span id="error_city" class="text-danger ms-3"></span>
            <input type="text" class="form-control city" name="city">
            <label class="form-label">Age:</label> <span id="error_age" class="text-danger ms-3"></span>
            <input type="number" class="form-control age" name="age">
</form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id='ajax-save'>Add Data</button>
      </div>
    </div>
  </div>
</div>


    <button class='btn btn-success' data-bs-toggle="modal" data-bs-target="#crudModal" id='add'>Add</button> <br><br>
    <input type="text" name="search_text" id="search_text" placeholder="Search Here" class="form-control"> <br>
    <div class="result">
</div>
    <div class="Tab">
     <table class='table table-success table-striped' id='myTable'>
        <thead>
                <tr>
                    <th>Id</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>City</th>
                    <th>Age</th>
                    <th>Actions</th>
    
                </tr>
</thead>
<tbody class = 'tab_bod'>
    <tbody>
<tbody class = 'res'>
    <tbody>
</table>
</div>
<div class='pagi'>
</div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>
  </body>
</html>