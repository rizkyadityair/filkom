
  <!-- Content Wrapper. Contains page content -->
    <form method="POST" action="<?= base_url('master/M_mitra/update') ?>" id="upload-create" enctype="multipart/form-data">
      <input type="hidden" name="m_id" value="<?= $m_mitra['m_id'] ?>">
      <div class="show_error"></div>

      <div class="form-group">
        <label for="form-m_name">Nama</label>
        <input type="text" class="form-control" id="form-m_name" placeholder="Masukan Nama" name="dt[m_name]" value="<?= $m_mitra['m_name'] ?>">
      </div>

      <div class="form-group">
        <label for="form-m_alamat">Alamat</label>
        <input type="text" class="form-control" id="form-m_alamat" placeholder="Masukan Alamat" name="dt[m_alamat]" value="<?= $m_mitra['m_alamat'] ?>">
      </div>

      <div class="form-group">
        <label for="form-m_cp_name">PIC / Nama Contact Person</label>
        <input type="text" class="form-control" id="form-m_cp_name" placeholder="Masukan PIC / Nama Contact Person" name="dt[m_cp_name]" value="<?= $m_mitra['m_cp_name'] ?>">
      </div>

      <div class="form-group">
        <label for="form-m_telp">Telp</label>
        <input type="text" class="form-control" id="form-m_telp" placeholder="Masukan Telp" name="dt[m_telp]" value="<?= $m_mitra['m_telp'] ?>">
      </div>

      <div class="text-right"> 
        <button type="submit" class="btn btn-primary btn-send" ><i class="fa fa-save"></i> Save</button>
        <button type="reset" class="btn btn-danger"><i class="fa fa-refresh"></i> Reset</button>
      </div>

    </form>
<!-- /.content-wrapper -->
<script type="text/javascript">
$(".money").simpleMoneyFormat();
tinymce.remove();
tinymce.init({
  selector: '.tinymces',
    cleanup : true,
  plugins: "localautosave",
  toolbar1: "localautosave",
  las_seconds: 15,
  las_nVersions: 15,
  las_keyName: "LocalAutoSave",
  las_callback: function() {
    var content = this.content; //content saved
    var time = this.time; //time on save action
  }
});

$("#upload-create").submit(function(){
  var form = $(this);
  var mydata = new FormData(this);
  $.ajax({
        type: "POST",
      url: form.attr("action"),
      data: mydata,
      cache: false,
      contentType: false,
      processData: false,
      beforeSend : function(){
            $(".btn-send").addClass("disabled").html("<i class='la la-spinner la-spin'></i>  Processing...").attr('disabled',true);
      },
      success: function(response, textStatus, xhr) {
            // alert(mydata);
          var str = response;
          if (str.indexOf("success") != -1){
              Swal.fire({
                  title: "It works!",
                  text: "Successfully updated data",
                  icon: "success"
              });

              setTimeout(function(){ 
                  idrow.html('<td>#</td>'+
                            '   <td></td>'+
'   <td>'+$("#form-m_name").val()+'</td>'+
                            '   <td>'+$("#form-m_alamat").val()+'</td>'+
                            '   <td>'+$("#form-m_cp_name").val()+'</td>'+
                            '   <td>'+$("#form-m_telp").val()+'</td>'+
                            
                            '   <td></td>'+
                            '   <td><label class="badge bg-green">Updated</label> <label class="badge bg-red" style="cursor:pointer" onclick="loadtable($(\'#select-status\').val());"><i class="fa fa-refresh"></i> </label></td>');
idrow.addClass('bg-warning');
                  
                  $("#modal-form").modal('hide');
              }, 1000);
              $(".btn-send").removeClass("disabled").html('<i class="fa fa-save"></i> Save').attr('disabled',false);
          }else{
              $(".btn-send").removeClass("disabled").html('<i class="fa fa-save"></i> Save').attr('disabled',false);
              Swal.fire({
                  title: "Oppss!",
                  html: str,
                  icon: "error"
              });
          }
      },
      error: function(xhr, textStatus, errorThrown) {
          console.log(xhr.responseText);
          Swal.fire({
                  title: "Oppss!",
                  text: xhr,
                  icon: "error"
              });
          $(".btn-send").removeClass("disabled").html('<i class="fa fa-save"></i> Save').attr('disabled',false);
      }
  });
  return false;

  });
  $('.select2').select2();
  $('.tgl').datepicker({
    autoclose: true,
    format:'yyyy-mm-dd'
  });

</script>