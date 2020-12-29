<div class="col-md-12">
  <div class="panel">
    <!-- /.panel-header -->
    <div class="panel-heading">
      <div class="col-md-12" style="padding: 0px;">
        <div class="col-md-4" style="padding: 0px;">
          <input type="search" id="txt-search-moa" class="form-control" placeholder="Search MOA...">
        </div>
        <div class="col-md-2">
          <button class="btn btn-primary" onclick="loadtablemoa();"><i class="fa fa-search"></i> Search</button>
        </div>
      </div>
      <br>
    </div>
    <div class="panel-body">
      <input type="hidden" id="dataId-moa">
      <div id="load-table-moa"></div>
      <button class="btn btn-danger btn-sm" type="button" onclick="hapuspilihdatamoa()" id="btn-hapus-data" style="margin-top: 10px;"><i class="fa fa-trash"></i> Hapus Data Terpilih</button>
      <div class="pull-right">
        <a href="<?= base_url('master/Kerja_sama/create?tipe=moa&mitra_id='.$mitra_id) ?>">
          <button type="button" class="btn btn-sm btn-addkerjasama" style="margin-top: 10px;"><i class="fa fa-plus"></i> Tambah Kerja Sama</button> 
        </a>
      </div>
    </div>
  </div>
</div>
<script>
  function buildData(){
      var json_filter = {
        'searchdata' : $('#txt-search-moa').val(), 
        'mitra_id' : '<?= $mitra_id?>', 
      }
      return json_filter;
    }
    var idrow = "";
    var idbutton = "";
    function loadtablemoa(status) {
      var table = '<table class="table table-condensed table-striped datatables" id="mytable_moa" >'+
                  '     <thead>'+
                  '     <tr style="margin-left:auto margin-right:auto">'+
                  '       <th style="width:20px">#</th>'+
                  '       <th style="width:20px">No</th>'+
                  '       <th>Mitra</th>'+
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
         $("#load-table-moa").html(table)
          var t = $("#mytable_moa").DataTable({
              initComplete: function() {
                  var api = this.api();
                $('#mytable_filter_moa input')
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

            ajax: {"url": "<?= base_url('master/Kerja_sama/jsonmoa?status=ENABLE') ?>", "type": "POST","data":buildData()},
            columns: [
                {"data": "ks_id","orderable": false, "className": "text-center"},
                {"data": "ks_id","orderable": false},
                {"data": "ks_mitra_name"},
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
                      return "<input type='checkbox' onclick='checkdatamoa($(this),"+row['ks_id']+")' value='"+row['ks_id']+"' "+checked+">";
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
            ],

            rowCallback: function(row, data, iDisplayIndex) {
                  var info = this.fnPagingInfo();
                var page = info.iPage;
                var length = info.iLength;
                var index = page * length + (iDisplayIndex + 1);
                $('td:eq(1)', row).html(index);
            }
        });
        $("#mytable_filter_moa").hide();
    }
    loadtablemoa();
    var arraymoa = [];
    function checkdatamoa(e,id) {
      if(e.is(':checked')){
        if(!arraymoa.includes(e.val())) arraymoa.push(e.val());
      }else{ 
            var removeItem = e.val();
          arraymoa = jQuery.grep(arraymoa, function(value) {
              return value != removeItem;
          });
      }
      $("#dataId-moa").val(arraymoa.join())
    }

    function hapuspilihdatamoa() {
      var data = $('#dataId-moa').val();
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
              loadtablemoa();
              $('#dataId-moa').val('');
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
    function editmoa(id,e) {
      location.href = "<?= base_url('master/Kerja_sama/edit/') ?>"+id;
    }
    function previewmoa(filedir,e) {
      window.open("<?= base_url('')?>"+filedir, "_blank");
    }
    function getstatusmoa(id,e) {
      location.href = '<?= base_url('master/kerja_sama/getstatus/')?>'+id+'?tipe=moa';
    }
</script>