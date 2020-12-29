 <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/circliful/2.0.17/main.css" integrity="sha512-NK4HHauNM/PN8erIU9un7qlAoRfjrk8rXxJOBXrksOn0232Kq1l5A9yGBuhIDuvLUr/plS0j1RDhsXHlXwoaEA==" crossorigin="anonymous" />
<style>
  svg{
    width: 50%;
  }
</style>
<?php
  $cekdata = $this->mymodel->selectWhere('kerja_sama_sub_bidang',['kssb_id_ks'=>$kerja_sama['ks_id']]);
?>
 <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Status Kerja Sama
        <small>Master</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">Master</a></li>
        <li class="active">Status Kerja Sama</li>
      </ol>
    </section>
    <?php if ($this->input->get('tipe')=='mou') {?>
      <!-- Main content MOU -->
      <section class="content">
        <div class="row">
          <div class="col-xs-12">
            <div class="panel">
              <!-- /.panel-header -->
              <div class="panel-heading">
                <div class="row">
                  <div class="col-md-12">
                    <div class="pull-right">
                    </div>
                  </div>  
                </div>
              </div>
              <div class="panel-body">
                <div class="col-md-4">
                  <h4>Persentase Kerjasama MOU</h4>
                  <center>
                    <div id="circle"></div>
                  </center>
                </div>
                <div class="col-md-8">
                  <h4>
                    Data Status
                    <?php
                      if (count($cekdata) < $kerja_sama['ks_semester']) {
                    ?>
                      <button class="btn btn-xs btn-primary" style="float: right;" onclick="tambahstatus();"><i class="fa fa-plus"></i> Tambah Status</button>
                    <?php }?>
                  </h4>
                  <div id="wrapper-load-data-status"></div>
                </div>
              </div>
              <!-- /.panel-body -->
            </div>
            <!-- /.panel -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
        <div id="modal-subbidang" class="modal fade" role="dialog">
      <div class="modal-dialog modal-md">
        <!-- Modal content-->
        <div class="modal-content">
          <div class="modal-header">
            <!-- <button type="button" class="close" data-dismiss="modal">&times;</button> -->
            <h4 class="modal-title"><?= $kerja_sama['ks_subidang']?></h4>
          </div>
          <form method="POST" action="<?= base_url('master/Kerja_sama/addsubbidangdata') ?>" id="upload-create" enctype="multipart/form-data">
            <div class="modal-body">
              <input type="hidden" name="no_mou" value="<?= $kerja_sama['ks_no_mou_filkom']?>">
              <input type="hidden" name="dt[kssb_id_ks]" value="<?= $kerja_sama['ks_id']?>">
              <input type="hidden" name="dt[kssb_sub_id]" value="<?= $kerja_sama['ks_subidang_id']?>">
              <input type="hidden" name="dt[kssb_sub_name]" value="<?= $kerja_sama['ks_subidang']?>">
              <div class="form-group">
                <label>Tanggal</label>
                <input type="date" class="form-control" name="dt[kssb_tgl]" >
              </div>
              <div class="form-group all">
                  <label for="form-file">File</label>
                  <input type="file" class="form-control" id="form-file" placeholder="Masukan File" name="file">
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
              <button type="submit" class="btn btn-primary btn-send">Submit</button>
            </div>
          </form>
        </div>
      </div>
    </div>

    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/circliful/2.0.17/circliful.js" integrity="sha512-+CsxiXgqKXUueZY9CEOkQY9lis7X/UlvKs3MEbfrnltNWG2gAFA4gqVSV0Vj9XSppV9t0rG5nBdVCn77NueoNQ==" crossorigin="anonymous"></script>
    <script>
      function loaddatastatus(id) {
        $('#wrapper-load-data-status').html('<center><i class="fa fa-spin fa-spinner"></i> Loading...</center>');
        $('#wrapper-load-data-status').load('<?= base_url('master/kerja_sama/getdatastatus/')?>'+id);
      }
      loaddatastatus(<?= $kerja_sama['ks_id']?>);
      function tambahstatus() {
        $("#modal-subbidang").modal("show");
      }
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
                form.find(".show_error").slideUp().html("");
            },
            success: function(response, textStatus, xhr) {
              
                  // alert(mydata);
               var str = response;
                if (str.indexOf("success") != -1){
                      Swal.fire({
                          title: "It works!",
                          text: "Successfully added data",
                          icon: "success"
                      });
                      // form.find(".show_error").hide().html(response).slideDown("fast");
                    setTimeout(function(){
                      location.reload();
                    }, 1000);
                    $(".btn-send").removeClass("disabled").html('<i class="fa fa-save"></i> Save').attr('disabled',false);
                }else{
                    Swal.fire({
                      title: "Oppss!",
                      html: str,
                      icon: "error"
                    });
                      // form.find(".show_error").hide().html(response).slideDown("fast");
                    $(".btn-send").removeClass("disabled").html('<i class="fa fa-save"></i> Save').attr('disabled',false);

                }
            },
            error: function(xhr, textStatus, errorThrown) {
                console.log(xhr);
                Swal.fire({
                    title: "Oppss!",
                    text: xhr,
                    icon: "error"
                });
                $(".btn-send").removeClass("disabled").html('<i class="fa fa-save"></i> Save').attr('disabled',false);
                // form.find(".show_error").hide().html(xhr).slideDown("fast");
            }
        });
        return false;
      });
      function deletedata(id) {
        Swal.fire({
            title: 'Warning ?',
          text: "Are you sure you delete this data",
          icon: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
              $.ajax({
                  url: '<?= base_url('master/kerja_sama/deletesubkejasama/')?>',
                type: 'post',
                dataType: 'html',
                data: {id: id},
                beforeSend:function () { },
                success:function(response, textStatus, xhr) {
                  var str = response;
                    if (str.indexOf("success") != -1){
                      Swal.fire(
                          'Deleted!',
                        'Your data has been deleted.',
                        'success'
                      );
                      location.reload();
                    }else{
                      Swal.fire({
                        title: "Oppss!",
                        html: str,
                        icon: "error"
                      });
                    }
                }
              }); 
          }
        })
      }
    </script>
    <?php
      // $now = time();
      // $tanggalmulai = strtotime($kerja_sama['ks_tgl_mulai']);
      // $datediff = $now - $tanggalmulai;
      // $sampaitanggal = round($datediff / (60 * 60 * 24));

      // $tanggal_selesai = strtotime($kerja_sama['ks_tgl_selesai']);
      // $tanggal_mulai = strtotime($kerja_sama['ks_tgl_mulai']);
      // $datediff = $tanggal_selesai - $tanggal_mulai;
      // $rangekerjasama = round($datediff / (60 * 60 * 24));

      // echo $sampaitanggal;

      if ($cekdata) {
        $datastatus = count($cekdata);
      }else{
        $datastatus = 0;
      }
      $persentase = ($datastatus/$kerja_sama['ks_semester'])*100;
      if ($persentase > 100) {
        $persentasebaru = 100;
      }else{
        $persentasebaru = round($persentase);
      }

    ?>
    <script>
      var persentase = '<?= $persentasebaru?>';
      $.ajax({
        url: '<?= base_url('master/kerja_sama/updatestatus/'.$kerja_sama['ks_id'])?>',
        type: 'post',
        dataType: 'html',
        data: {
          persentase: persentase
        },
        success:function() {

        }
      });
    </script>
    <script>
        circliful.newCircle({
            percent: <?= $persentasebaru?>,
            id: 'circle',
            type: 'simple',
        });
    </script>
      </section>
  <?php }?>
  <?php if ($this->input->get('tipe')=='moa') {?>
    <!-- Main content MOA -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="panel">
            <!-- /.panel-header -->
            <div class="panel-heading">
              <div class="row">
                <div class="col-md-12">
                  <div class="pull-right">
                  </div>
                </div>  
              </div>
            </div>
            <div class="panel-body">
              <div class="col-md-4">
                <h4>Persentase Kerjasama MOA</h4>
                <center>
                  <div id="circle2"></div>
                </center>
              </div>
              <div class="col-md-8">
                <h4>
                  Data Status
                  <?php
                    if (count($cekdata) < $kerja_sama['ks_semester']) {
                  ?>
                    <button class="btn btn-xs btn-primary" style="float: right;" onclick="tambahstatus();"><i class="fa fa-plus"></i> Tambah Status</button>
                  <?php }?>
                </h4>
                <div id="wrapper-load-data-status-2"></div>
              </div>
            </div>
            <!-- /.panel-body -->
          </div>
          <!-- /.panel -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
      <div id="modal-subbidang" class="modal fade" role="dialog">
    <div class="modal-dialog modal-md">
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <!-- <button type="button" class="close" data-dismiss="modal">&times;</button> -->
          <h4 class="modal-title"><?= $kerja_sama['ks_subidang']?></h4>
        </div>
        <form method="POST" action="<?= base_url('master/Kerja_sama/addsubbidangdata') ?>" id="upload-create" enctype="multipart/form-data">
          <div class="modal-body">
            <input type="hidden" name="no_moa" value="<?= $kerja_sama['ks_no_moa_filkom']?>">
            <input type="hidden" name="dt[kssb_id_ks]" value="<?= $kerja_sama['ks_id']?>">
            <input type="hidden" name="dt[kssb_sub_id]" value="<?= $kerja_sama['ks_subidang_id']?>">
            <input type="hidden" name="dt[kssb_sub_name]" value="<?= $kerja_sama['ks_subidang']?>">
            <div class="form-group">
              <label>Tanggal</label>
              <input type="date" class="form-control" name="dt[kssb_tgl]" >
            </div>
            <div class="form-group all">
                <label for="form-file">File</label>
                <input type="file" class="form-control" id="form-file" placeholder="Masukan File" name="file">
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary btn-send">Submit</button>
          </div>
        </form>
      </div>
    </div>
  </div>

  
  <script src="https://cdnjs.cloudflare.com/ajax/libs/circliful/2.0.17/circliful.js" integrity="sha512-+CsxiXgqKXUueZY9CEOkQY9lis7X/UlvKs3MEbfrnltNWG2gAFA4gqVSV0Vj9XSppV9t0rG5nBdVCn77NueoNQ==" crossorigin="anonymous"></script>
  <script>
    function loaddatastatus(id) {
      $('#wrapper-load-data-status-2').html('<center><i class="fa fa-spin fa-spinner"></i> Loading...</center>');
      $('#wrapper-load-data-status-2').load('<?= base_url('master/kerja_sama/getdatastatus/')?>'+id);
    }
    loaddatastatus(<?= $kerja_sama['ks_id']?>);
    function tambahstatus() {
      $("#modal-subbidang").modal("show");
    }
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
              form.find(".show_error").slideUp().html("");
          },
          success: function(response, textStatus, xhr) {
            
                // alert(mydata);
             var str = response;
              if (str.indexOf("success") != -1){
                    Swal.fire({
                        title: "It works!",
                        text: "Successfully added data",
                        icon: "success"
                    });
                    // form.find(".show_error").hide().html(response).slideDown("fast");
                  setTimeout(function(){
                    location.reload();
                  }, 1000);
                  $(".btn-send").removeClass("disabled").html('<i class="fa fa-save"></i> Save').attr('disabled',false);
              }else{
                  Swal.fire({
                    title: "Oppss!",
                    html: str,
                    icon: "error"
                  });
                    // form.find(".show_error").hide().html(response).slideDown("fast");
                  $(".btn-send").removeClass("disabled").html('<i class="fa fa-save"></i> Save').attr('disabled',false);

              }
          },
          error: function(xhr, textStatus, errorThrown) {
              console.log(xhr);
              Swal.fire({
                  title: "Oppss!",
                  text: xhr,
                  icon: "error"
              });
              $(".btn-send").removeClass("disabled").html('<i class="fa fa-save"></i> Save').attr('disabled',false);
              // form.find(".show_error").hide().html(xhr).slideDown("fast");
          }
      });
      return false;
    });
    function deletedata(id) {
      Swal.fire({
          title: 'Warning ?',
        text: "Are you sure you delete this data",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!'
      }).then((result) => {
          if (result.isConfirmed) {
            $.ajax({
                url: '<?= base_url('master/kerja_sama/deletesubkejasama/')?>',
              type: 'post',
              dataType: 'html',
              data: {id: id},
              beforeSend:function () { },
              success:function(response, textStatus, xhr) {
                var str = response;
                  if (str.indexOf("success") != -1){
                    Swal.fire(
                        'Deleted!',
                      'Your data has been deleted.',
                      'success'
                    );
                    location.reload();
                  }else{
                    Swal.fire({
                      title: "Oppss!",
                      html: str,
                      icon: "error"
                    });
                  }
              }
            }); 
        }
      })
    }
  </script>
  <?php
    // $now = time();
    // $tanggalmulai = strtotime($kerja_sama['ks_tgl_mulai']);
    // $datediff = $now - $tanggalmulai;
    // $sampaitanggal = round($datediff / (60 * 60 * 24));

    // $tanggal_selesai = strtotime($kerja_sama['ks_tgl_selesai']);
    // $tanggal_mulai = strtotime($kerja_sama['ks_tgl_mulai']);
    // $datediff = $tanggal_selesai - $tanggal_mulai;
    // $rangekerjasama = round($datediff / (60 * 60 * 24));

    // echo $sampaitanggal;

    if ($cekdata) {
      $datastatus = count($cekdata);
    }else{
      $datastatus = 0;
    }
    $persentase = ($datastatus/$kerja_sama['ks_semester'])*100;
    if ($persentase > 100) {
      $persentasebaru = 100;
    }else{
      $persentasebaru = round($persentase);
    }

  ?>
  <script>
    var persentase = '<?= $persentasebaru?>';
    $.ajax({
      url: '<?= base_url('master/kerja_sama/updatestatus/'.$kerja_sama['ks_id'])?>',
      type: 'post',
      dataType: 'html',
      data: {
        persentase: persentase
      },
      success:function() {

      }
    });
  </script>
  <script>
      circliful.newCircle({
          percent: <?= $persentasebaru?>,
          id: 'circle2',
          type: 'simple',
      });
  </script>
    </section>
  <?php }?>
  </div>
  
  