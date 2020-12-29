<style>
  .btn-addkerjasama{
    background-color: rgb(255, 188, 64);
    color: white;
  }
  .btn-addkerjasama:hover{
    background-color: orange;
    color: white !important;
  }
</style>
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
        <li><a href="#">Master</a></li>
        <li class="active">Kerja Sama</li>
      </ol>
    </section>
    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="panel">
            <!-- /.panel-header -->
            <div class="panel-heading">
              <div class="row">
                <div class="col-md-12">
                  <div class="col-md-4">
                    <input type="search" id="txt-search" class="form-control" placeholder="Search MOU...">
                  </div>
                  <div class="col-md-2">
                    <button class="btn btn-primary" onclick="loadtable();"><i class="fa fa-search"></i> Search</button>
                  </div>
                </div>  
              </div>
            </div>
            <div class="panel-body">
                <div class="filter">
                </div>
                <input type="hidden" id="dataId">
                <div id="load-table"></div>
                <button class="btn btn-danger btn-sm" type="button" onclick="hapuspilihdata()" id="btn-hapus-data" style="margin-top: 10px;"><i class="fa fa-trash"></i> Hapus Data Terpilih</button>
                <div class="pull-right">
                  <button type="button" class="btn btn-sm btn-success" style="margin-top: 10px;" onclick="exportkerjasama();"><i class="fa fa-file"></i> Export Kerja Sama</button>
                  <a href="<?= base_url('master/Kerja_sama/create') ?>">
                    <button type="button" class="btn btn-sm btn-addkerjasama" style="margin-top: 10px;"><i class="fa fa-plus"></i> Tambah Kerja Sama</button> 
                  </a>
                </div>
            </div>
            <!-- /.panel-body -->
          </div>
          <!-- /.panel -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <div class="modal fade" id="modal-impor">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          <h4 class="modal-title">Impor Kerja Sama</h4>
        </div>
        <form action="<?= base_url('fitur/impor/kerja_sama') ?>" method="POST"  enctype="multipart/form-data">
        <div class="modal-body">
            <div class="form-group">
              <label for="">File Excel</label>
              <input type="file" class="form-control" id="" name="file" placeholder="Input field">
            </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-times"></i> Close</button>
          <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Save</button>
        </div>
        </form>
      </div>
    </div>
  </div>

  <!-- Modal -->
  <div id="modal-status" class="modal fade" role="dialog">
    <div class="modal-dialog">
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Status Kerja Sama</h4>
        </div>
        <div class="modal-body">
          <div id="wrapper-modal-status">
            
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>

    </div>
  </div>

  <!-- Modal -->
  <div id="modal-list-moa" class="modal fade" role="dialog">
    <div class="modal-dialog" style="width: 90%;">
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">List MOA</h4>
        </div>
        <div class="modal-body">
          <div id="wrapper-data-moa-mitra"></div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>

    </div>
  </div>

  <script type="text/javascript">
    
    function buildData(){
      var json_filter = {
        'filter_ks_mitra_name' : $('#filter_ks_mitra_name').val(), 
        'searchdata' : $('#txt-search').val(), 
      }
      return json_filter;
    }
        

    var idrow = "";
    var idbutton = "";

    function loadtable(status) {
          var table = '<table class="table table-condensed table-striped datatables" id="mytable" >'+
                      '     <thead>'+
                      '     <tr style="margin-left:auto margin-right:auto">'+
                      '       <th style="width:20px">#</th>'+
                      '       <th style="width:20px">No</th>'+
                      '       <th>Mitra</th>'+
                      '       <th>MOU</th>'+
                      '       <th>MOA</th>'+
                      '       <th>Jangka Waktu</th>'+
                      '       <th>Bidang Kerjasama</th>'+
                      '       <th>Progress Terakhir</th>'+
                      '       <th style="width:150px"></th>'+
                      '     </tr>'+
                      '     </thead>'+
                      '     <tbody>'+
                      '     </tbody>'+
                      ' </table>';
             // body...
             $("#load-table").html(table)
              var t = $("#mytable").DataTable({
                  initComplete: function() {
                      var api = this.api();
                    $('#mytable_filter input')
                            .off('.DT')
                            .on('keyup.DT', function(e) {
                                  if (e.keyCode == 13) {
                                      api.search(this.value).draw();
                        }
                    });
                },
                oLanguage: {
                      sProcessing: "loading..."
                },
                processing: true,
                serverSide: true,orderCellsTop: true,

                ajax: {"url": "<?= base_url('master/Kerja_sama/json?status=ENABLE') ?>", "type": "POST","data":buildData()},
                columns: [
                    {"data": "ks_id","orderable": false, "className": "text-center"},
                    {"data": "ks_id","orderable": false},
                    {"data": "ks_mitra_name"},
                    {"data": "ks_no_mou_filkom"},
                    {"data": "ks_no_moa_filkom"},
                    {"data": "ks_jangka_waktu"},
                    {"data": "ks_bidang"},
                    {"data": "ks_progress"},
                    {"data": "view", "orderable": false
                    }
                ],
                order: [[1, 'asc']],
                columnDefs : [
                    { 
                      targets : [0],
                        render : function (data, type, row, meta,id,e) {
                          var cbinput = $("#dataId").val();
                          cb = cbinput.split(',');
                          var checked = "";
                          if(cb.includes(row['ks_id'])) checked = "checked";
                          if(cbinput=="all") checked = "checked";
                          return "<input type='checkbox' onclick='checkdata($(this),"+row['ks_id']+")' value='"+row['ks_id']+"' "+checked+">";
                          }
                    },
                    { 
                      targets : [1],
                      render : function (data, type, row, meta,id,e) {
                          var htmls = "";
                          
                          if(data == "MOU"){
                                htmls = "MOU";
                          }
                          if(data == "MOA"){
                                htmls = "MOA";
                          }
                          return htmls;
                        }
                    },
                    { 
                      targets : [3],
                      render : function (data, type, row, meta,id,e) {
                          if (row['ks_no_mou_filkom']){
                            var htmls = row['ks_no_mou_filkom'];
                          }else{
                            var htmls = '<a href="<?= base_url('master/kerja_sama/create')?>?tipe=mou&mitra_id='+row['ks_mitra_id']+'" class="btn btn-xs btn-default" target="_blank"><i class="fa fa-plus"></i></a>';
                          }
                          return htmls;
                        }
                    },
                    { 
                      targets : [5],
                      render : function (data, type, row, meta,id,e) {
                          if (row['ks_no_mou_filkom']){
                            var htmls = row['ks_jangka_waktu'];
                          }else{
                            var htmls = 'Silahkan isi MOU terlebih dahulu';
                          }
                          return htmls;
                        }
                    },
                    { 
                      targets : [6],
                      render : function (data, type, row, meta,id,e) {
                          if (row['ks_no_mou_filkom']){
                            var htmls = row['ks_bidang'];
                          }else{
                            var htmls = 'Silahkan isi MOU terlebih dahulu';
                          }
                          return htmls;
                        }
                    },
                    { 
                      targets : [7],
                      render : function (data, type, row, meta,id,e) {
                          if (row['ks_no_mou_filkom']){
                            var htmls = row['ks_progress'];
                          }else{
                            var htmls = 'Silahkan isi MOU terlebih dahulu';
                          }
                          return htmls;
                        }
                    },
                    { 
                      targets : [8],
                      render : function (data, type, row, meta,id,e) {
                          if (row['ks_no_mou_filkom']){
                            var htmls = row['view'];
                          }else{
                            var htmls = 'Silahkan isi MOU terlebih dahulu';
                          }
                          return htmls;
                        }
                    },
                ],

                rowCallback: function(row, data, iDisplayIndex) {
                      var info = this.fnPagingInfo();
                    var page = info.iPage;
                    var length = info.iLength;
                    var index = page * length + (iDisplayIndex + 1);
                    $('td:eq(1)', row).html(index);
                    jQuery.ajax({
                      url: '<?= base_url('master/kerja_sama/getdatamoamitra'); ?>/'+data['ks_mitra_id'],
                      type: 'POST',
                      dataType: 'html',
                      beforeSend: function(datas, textStatus, xhr) {
                      $('td:eq(4)', row).html('<i class="fa fa-spinner fa-spin"></i> Loading...');
                      },
                      success: function(datas, textStatus, xhr) {
                      $('td:eq(4)', row).html(datas);
                      },
                      error: function(xhr, textStatus, errorThrown) {
                      $('td:eq(4)', row).html('-');
                      }
                    });
                }
            });
            $("#mytable_filter").hide();
         }
         loadtable($("#select-status").val());
           
      function edit(id,e) {
              location.href = "<?= base_url('master/Kerja_sama/edit/') ?>"+id;
         }         
      function hapus(id,e) {
        idrow = e.parent().parent().parent();
        idbutton = e.parent().parent();
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
                  url: '<?= base_url('master/kerja_sama/delete/')?>',
                type: 'post',
                dataType: 'html',
                data: {id: id},
                beforeSend:function () { },
                success:function(response, textStatus, xhr) {
                  var str = response;
                    if (str.indexOf("success") != -1){
                      idbutton.html('<label class="badge bg-red">Deleted</label> <label class="badge bg-red" style="cursor:pointer" onclick="loadtable($(\'#select-status\').val());"><i class="fa fa-refresh"></i> </label>');
                      idrow.addClass('bg-danger');
                      Swal.fire(
                          'Deleted!',
                        'Your data has been deleted.',
                        'success'
                      );
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

      var array = [];
      function checkdata(e,id) {
        if(e.is(':checked')){
          if(!array.includes(e.val())) array.push(e.val());
        }else{ 
              var removeItem = e.val();
            array = jQuery.grep(array, function(value) {
                return value != removeItem;
            });
        }
        $("#dataId").val(array.join())
      }

      function hapuspilihdata() {
        var data = $('#dataId').val();
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
              url: '<?= base_url('master/kerja_sama/Deletedata/')?>',
              type: 'post',
              dataType: 'html',
              data: {data: data},
              beforeSend:function () {

              },
              success:function() {
                loadtable($("#select-status").val());
                $('#dataId').val('');
                Swal.fire(
                            'Deleted!',
                          'Your data has been deleted.',
                          'success'
                        )
              }
            }); 
          }
        })
      }

      function preview(filedir,e) {
        window.open("<?= base_url('')?>"+filedir, "_blank");
      }
      function getstatus(id,e) {
        location.href = '<?= base_url('master/kerja_sama/getstatus/')?>'+id+'?tipe=mou';
      }
      function exportkerjasama() {
        location.href='<?= base_url('master/kerja_sama/exportkerjasama')?>';
      }
      function getlistmoa(mitra_id) {
        $('#modal-list-moa').modal('show');
        $('#wrapper-data-moa-mitra').html('<center><i class="fa fa-spin fa-spinner"></i> Loading...</center>');
        $('#wrapper-data-moa-mitra').load('<?= base_url('master/kerja_sama/loadlistmoa/')?>'+mitra_id);
      }
  </script>