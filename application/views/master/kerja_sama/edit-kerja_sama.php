
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Kerja Sama
        <small>Master</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">master</a></li>
        <li class="active">Kerja Sama</li>
      </ol>
    </section>
    <!-- Main content -->
    <section class="content">
    <form method="POST" action="<?= base_url('master/Kerja_sama/update') ?>" id="upload-create" enctype="multipart/form-data">
      <div class="row">
        <div class="col-xs-8">
          <div class="panel">
            <!-- /.panel-header -->
            <div class="panel-heading">
              <h5 class="panel-title">
                  Edit Kerja Sama
              </h5>
            </div>
            <div class="panel-body">
              <input type="hidden" name="ks_id" value="<?= $kerja_sama['ks_id']?>">
              <div class="show_error"></div>
              <div class="form-group">
                  <label for="form-ks_tipe">Tipe</label>
                  <select name="ks_tipe" class="form-control" onchange="gettipe();" id="sel-tipe">
                    <option value="">Pilih</option>
                    <option value="mou" <?=($kerja_sama['ks_tipe']=="mou")?"selected":""?>>MOU</option>
                    <option value="moa" <?=($kerja_sama['ks_tipe']=="moa")?"selected":""?>>MOA</option>
                  </select>
              </div>

                <div class="form-group all">
                    <label for="form-ks_mitra_name">Mitra name <small id="spn-loading-mitra"></small></label>
                    <select name="ks_mitra_id" class="form-control select2" style="width:100%" id="sel-mitra" onchange="getallmitra()" disabled="">
                      <option value="" disabled="">Pilih Mitra</option>
                      <?php 
                      $m_mitra = $this->mymodel->selectWhere('m_mitra',null);
                      foreach ($m_mitra as $m_mitra_record) {
                        $text = "";
                        if($m_mitra_record['m_id']==$kerja_sama['ks_mitra_id']){
                          $text = "selected";
                        }
                        echo "<option value=".$m_mitra_record['m_id']." ".$text." >".$m_mitra_record['m_name']."</option>";
                      }
                      ?>
                    </select>
                </div>
                <div class="form-group mou">
                  <label>Nomor MOU Filkom</label>
                  <input type="text" class="form-control" placeholder="Nomor MOU Filkom" name="ks_no_mou_filkom" value="<?= $kerja_sama['ks_no_mou_filkom']?>">
                </div>
                <div class="form-group mou">
                  <label>Nomor MOU Mitra</label>
                  <input type="text" class="form-control" placeholder="Nomor MOU Mitra" name="ks_no_mou_mitra" value="<?= $kerja_sama['ks_no_mou_mitra']?>">
                </div>
                <div class="form-group mou">
                  <label>Tanggal Mulai</label>
                  <input type="date" name="ks_tgl_mulai_mou" class="form-control" placeholder="Tanggal Mulai" id="txt-tgl-mulai-mou" onchange="getrangedatemou()" value="<?= $kerja_sama['ks_tgl_mulai']?>">
                </div>
                <div class="form-group mou">
                  <label>Tanggal Selesai</label>
                  <input type="date" name="ks_tgl_selesai_mou" class="form-control" placeholder="Tanggal Selesai" id="txt-tgl-selesai-mou" onchange="getrangedatemou()" value="<?= $kerja_sama['ks_tgl_selesai']?>">
                </div>
                <div class="form-group mou">
                  <label>Jangka Waktu</label>
                  <input type="text" name="ks_jangka_waktu_mou" class="form-control" placeholder="Jangka Waktu" id="txt-jangka-waktu-mou" readonly value="<?= $kerja_sama['ks_jangka_waktu']?>">
                </div>
                <div class="form-group mou">
                  <label>Bidang Kerja Sama</label>
                  <select class="form-control select2" name="ks_bidang_id_mou" style="width: 100%;">
                    <option value="">Pilih</option>
                    <?php foreach ($bidang_kerjasama as $valbidangkerjasama) {?>
                      <option value="<?= $valbidangkerjasama['mbk_id']?>" <?=($kerja_sama['ks_bidang_id']==$valbidangkerjasama['mbk_id'])?"selected":""?>><?= $valbidangkerjasama['mbk_name']?></option>
                    <?php }?>
                  </select>
                </div>
                <div class="form-group mou">
                  <label>Biaya</label>
                  <input type="text" name="ks_biaya_mou" class="form-control money" placeholder="Biaya" value="<?= $kerja_sama['ks_biaya']?>">
                </div>
                <div class="form-group mou">
                  <label>Contact Person Filkom</label>
                  <input type="text" name="ks_cp_filkom_mou" class="form-control" placeholder="Contact Person Filkom" value="<?= $kerja_sama['ks_cp_filkom']?>">
                </div>
                <div class="form-group mou">
                  <label>Contact Person Mitra</label>
                  <input type="text" name="ks_cp_mitra_mou" class="form-control" placeholder="Contact Person Mitra" readonly="" id="txt-cp-mitra-mou" value="<?= $kerja_sama['ks_cp_mitra']?>">
                </div>
                <div class="form-group mou">
                  <label>Tindak Lanjut MOU</label>
                  <input type="text" name="ks_tindak_lanjut_mou" class="form-control" placeholder="Tindak Lanjut MOU" value="<?= $kerja_sama['ks_tindak_lanjut']?>">
                </div>
                <div class="form-group moa">
                  <label>Tanggal Mulai</label>
                  <input type="date" name="ks_tgl_mulai_moa" class="form-control" placeholder="Tanggal Mulai" id="txt-tgl-mulai-moa" onchange="getrangedatemoa();" value="<?= $kerja_sama['ks_tgl_mulai']?>">
                </div>
                <div class="form-group moa">
                  <label>Tanggal Selesai</label>
                  <input type="date" name="ks_tgl_selesai_moa" class="form-control" placeholder="Tanggal Selesai" id="txt-tgl-selesai-moa" onchange="getrangedatemoa();" value="<?= $kerja_sama['ks_tgl_selesai']?>">
                </div>
                <div class="form-group moa">
                  <label>Jangka Waktu</label>
                  <input type="text" name="ks_jangka_waktu_moa" class="form-control" placeholder="Jangka Waktu" id="txt-jangka-waktu-moa" readonly value="<?= $kerja_sama['ks_jangka_waktu']?>">
                </div>
                <div class="form-group moa">
                  <label>Nomor PKS (MOA) Filkom</label>
                  <input type="text" class="form-control" placeholder="Nomor PKS (MOA) Filkom" name="ks_no_moa_filkom" value="<?= $kerja_sama['ks_no_mou_filkom']?>">
                </div>
                <div class="form-group moa">
                  <label>Nomor PKS (MOA) Mitra</label>
                  <input type="text" class="form-control" placeholder="Nomor PKS (MOA) Mitra" name="ks_no_moa_mitra" value="<?= $kerja_sama['ks_no_mou_mitra']?>">
                </div>
                <div class="form-group moa">
                  <label>Bidang Kerja Sama</label>
                  <select class="form-control select2" name="ks_bidang_id_moa" id="sel-bidang-kerjasama-moa" onchange="getsubbidang()" style="width: 100%;">
                    <option value="">Pilih</option>
                    <?php foreach ($bidang_kerjasama as $valbidangkerjasama) {?>
                      <option value="<?= $valbidangkerjasama['mbk_id']?>" <?=($kerja_sama['ks_bidang_id']==$valbidangkerjasama['mbk_id'])?"selected":""?>><?= $valbidangkerjasama['mbk_name']?></option>
                    <?php }?>
                  </select>
                </div>
                <div class="form-group moa">
                  <label>Sub Bidang Kerjasama</label>
                  <select class="form-control select2" id="sel-sub-kerjasama" name="ks_subidang_id_moa" style="width: 100%;">
                    <option value="" disabled="" selected="">Pilih Sub Bidang Kerjasama</option>
                  </select>
                </div>
                <div class="form-group moa">
                  <label>Alamat Mitra</label>
                  <input type="text" name="ks_alamat_mitra_moa" class="form-control" placeholder="Alamat Mitra" readonly="" id="txt-alamat-moa" value="<?= $kerja_sama['ks_alamat_mitra']?>">
                </div>
                <div class="form-group moa">
                  <label>Tindak Lanjut MOA</label>
                  <input type="text" name="ks_tindak_lanjut_moa" class="form-control" placeholder="Tindak Lanjut MOA" value="<?= $kerja_sama['ks_tindak_lanjut']?>">
                </div>
                <div class="form-group all">
                  <label style="font-weight:10 !important";>Semester</label>
                  <select class="form-control select2" name="ks_semester" style="width: 100%;">
                    <?php for ($i=1; $i < 11; $i++) {?>
                      <option value="<?= $i?>" <?= ($kerja_sama['ks_semester']==$i)?'selected':'' ?> ><?= $i?></option>
                    <?php }?>
                  </select>
                </div>
                <?php
                  if($file['dir']!=""){
                      $types = explode("/", $file['mime']);
                    if($types[0]=="image"){
                      ?>
                      <img src="<?= base_url($file['dir']) ?>" style="width: 200px" class="img img-thumbnail">
                      <br>
                    <?php }else{ ?>

                      <i class="fa fa-file fa-5x text-danger"></i>
                      <br>
                      <a href="<?= base_url($file['dir']) ?>" target="_blank"><i class="fa fa-download"></i> <?= $file['name'] ?></a>
                      <br>
                      <br>
                    <?php } ?>
                <?php } ?>
                <div class="form-group all">
                    <label for="form-file">File</label>
                    <input type="file" class="form-control" id="form-file" placeholder="Masukan File" name="file" accept="application/pdf">
                </div>
            </div>
            <div class="panel-footer">
              <button type="submit" class="btn btn-primary btn-send" ><i class="fa fa-save"></i> Save</button>
              <button type="reset" class="btn btn-danger"><i class="fa fa-refresh"></i> Reset</button>
            </div>
            <!-- /.panel-body -->
          </div>
          <!-- /.panel -->
          <!-- /.panel -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
      </form>
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  <script type="text/javascript">

    function getsubbidang() {
      var bidang_kerjasama = $('#sel-bidang-kerjasama-moa').val();
      $.ajax({
        url: '<?= base_url('master/Kerja_sama/getsubbidang?bidang_kerjasama=')?>'+bidang_kerjasama+'&selected=<?= $kerja_sama['ks_subidang_id']?>',
        type: 'post',
        dataType: 'html',
        beforeSend:function () {
          $('#sel-sub-kerjasama').html('<option>Loading...</option>');
        },
        success:function (response) {
          $('#sel-sub-kerjasama').html(response);
        }
      });
    }
    getsubbidang();
    function gettipe() {
      var tipe = $('#sel-tipe').val();
      if (tipe=='moa') {
        $('.moa').fadeIn();
        $('.all').fadeIn();
        $('.mou').fadeOut();
        getrangedatemoa();
      }else if (tipe=='mou') {
        $('.moa').fadeOut();
        $('.mou').fadeIn();
        $('.all').fadeIn();
        getrangedatemou();
      }else{
        $('.moa').fadeOut();
        $('.mou').fadeOut();
        $('.all').fadeOut();
      }
    }
    gettipe();

    function getallmitra() {
      var mitra = $('#sel-mitra').val();
      $.ajax({
        url: '<?= base_url('master/m_mitra/getalldatamitra')?>',
        type: 'post',
        dataType: 'html',
        data: {
          mitra_id: mitra
        },
        beforeSend:function() {
          $('#spn-loading-mitra').html('<i class="fa fa-spin fa-spinner"></i> Mengambil data...');
        },
        success:function(response) {
          $('#spn-loading-mitra').html('');
          var str = JSON.parse(response);
          $('#txt-cp-mitra-mou').val(str.cp);
          $('#txt-alamat-moa').val(str.alamat);
        }
      });
    }

    getallmitra();

    function diff_year_month_day(dt1, dt2) 
    {
      var time =(dt2.getTime() - dt1.getTime()) / 1000;
      // var year  = Math.abs(Math.round((time/(60 * 60 * 24))/365.25));
      // var month = Math.abs(Math.round(time/(60 * 60 * 24 * 7 * 4)));
      var days = Math.abs(Math.round(time/(3600 * 24)));
      // if (year!=0) {
      //   var monthyear = month-13*year;
      //   var daysyear = days-365*year;
      //   return daysyear+" Hari, "+monthyear+" Bulan, "+year+" Tahun";
      // }else{
      //   if (month!=0) {
      //     var daysmoth = days-30*month;
      //     return daysmoth+" Hari, "+month+" Bulan";
      //   }else{
          // if (days!=0) {
            return days+" Hari";
      //     }
      //   }
      // }
      // return "Year :- " + year + " Month :- " + month + " Days :-" + days;
    }

    function getrangedatemou() {
      var tgl_mulai = new Date($('#txt-tgl-mulai-mou').val());
      var tgl_selesai = new Date($('#txt-tgl-selesai-mou').val());
      var getrange = diff_year_month_day(tgl_mulai, tgl_selesai);
      $('#txt-jangka-waktu-mou').val(getrange);
      // alert(tgl_mulai);
    }
    function getrangedatemoa() {
      var tgl_mulai = new Date($('#txt-tgl-mulai-moa').val());
      var tgl_selesai = new Date($('#txt-tgl-selesai-moa').val());
      var getrange = diff_year_month_day(tgl_mulai, tgl_selesai);
      $('#txt-jangka-waktu-moa').val(getrange);
      // alert(tgl_mulai);
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
                             window.location.href = "<?= base_url('master/Kerja_sama') ?>";
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
  </script>