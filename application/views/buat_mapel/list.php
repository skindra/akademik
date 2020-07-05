<br>
<br>
<?php if(showFlashMessage()){
    echo showFlashMessage();
};?>
<div class="col-md-12">
    <!-- start: DYNAMIC TABLE PANEL -->
    <div class="panel panel-default">
        <div class="panel-heading">
            <i class="fa fa-external-link-square"></i> Tabel Mata Pelajaran
            <div class="panel-tools">
                <?php echo anchor('buat_mapel/add','<i class="fa fa-pencil-square-o" aria-hidden="true">[DATA BARU]</i>',"title='Tambah Data'");?>
            <!--    <a class="btn btn-xs btn-link panel-collapse collapses" href="#"> </a>
                <a class="btn btn-xs btn-link panel-config" href="#panel-config" data-toggle="modal"> <i class="fa fa-wrench"></i> </a>
                <a class="btn btn-xs btn-link panel-refresh" href="#"> <i class="fa fa-refresh"></i> </a>
                <a class="btn btn-xs btn-link panel-expand" href="#"> <i class="fa fa-resize-full"></i> </a>
                <a class="btn btn-xs btn-link panel-close" href="#"> <i class="fa fa-times"></i> </a> -->
            </div>
        </div>
        <div class="panel-body">
            <table id="mytable" class="table table-striped table-bordered table-hover table-full-width dataTable" cellspacing="0" width="100%">
                <thead>
                    <tr>
                        <th>NO</th>
                        <th>GEL</th>
                        <th>MAPEL</th>
                        <th>JUMLAH SOAL</th>
                        <th>TAMPIL SOAL</th>
                        <th>BOBOT SOAL</th>
                        <th>STATUS SOAL</th>
                        <th>AKSI</th>
                    </tr>
                </thead>
                <tbody >
                </tbody>
            </table>
        </div>
    </div>
    <!-- end: DYNAMIC TABLE PANEL -->
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.0/jquery.dataTables.js"></script>
<script src="https://cdn.datatables.net/1.10.12/js/dataTables.bootstrap.js"></script>


  <script>
        $(document).ready(function() {
            var t = $('#mytable').DataTable( {
                "ajax": '<?php echo site_url('buat_mapel/data'); ?>',
                "order": [[ 2, 'asc' ]],
                "columns": [
                    {
                        "data": null,
                        "width": "50px",
                        "sClass": "text-center",
                        "orderable": false,
                    },
                    {
                        "data": "id_gelombang"
                    },
                    {
                        "data": "nama_mapel"
                    },
                    {
                        "data": "jml_soal"
                    },
                    {
                        "data": "tampil_soal"
                    },
                    {
                        "data": "bobot_soal"
                    },
                    {
                        "data": "status_soal"
                    },
                    { "data": "aksi","width": "120px" },
                ]
            } );
               
            t.on( 'order.dt search.dt', function () {
                t.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
                    cell.innerHTML = i+1;
                } );
            } ).draw();
        } );
    </script>