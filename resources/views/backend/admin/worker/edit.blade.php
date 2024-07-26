<form id='edit' action="" enctype="multipart/form-data" method="post" accept-charset="utf-8">
        <b style="display: block;text-align: center; margin-bottom: 20px; font-size:20px;">USER </b>
        <fieldset class="form-group border p-3" style="box-shadow: 0 2px 5px rgba(0,0,0,0.2),-2px 0 5px rgba(0,0,0,0.2),  2px 0 5px rgba(0,0,0,0.2);margin-top:-17px;">
        <div id="status"></div>
        {{method_field('PATCH')}}
            <div class="form-row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="id">ID</label>
                            <input type="id" class="form-control" id="id" name="id" value="{{ $worker->id }}" placeholder="Your id">
                            <span id="error_id" class="has-error"></span>
                        </div>
                        </div>
                        <div class="col-md-6">
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" class="form-control" id="name" name="name" value="{{ $worker->name }}" placeholder="Your Name">
                            <span id="error_name" class="has-error"></span>
                        </div>
                    </div>
            </div>
        </fieldset>     
        <div class="clearfix"></div>
        <div class="form-group col-md-12">
            <button type="submit" class="btn btn-success button-submit" data-loading-text="Loading..."><span class="fa fa-save fa-fw"></span> Save</button>
        </div>
    </form>

    <script>
       $('input[type="radio"].flat-green').iCheck({
        radioClass: 'iradio_flat-green'
    });
        $('.button-submit').click(function () {
            // route name and record id
            ajax_submit_update('worker', "{{ $worker->id }}")
        });
        $(document).ready(function() {
    // Ambil path foto dari data yang ada di database untuk Kop Surat
    var potoFilePath = "{{ asset($worker->poto) }}";

    if (potoFilePath !== "{{ asset('assets/images/worker/') }}") { // Jika ada path foto yang tersedia
        $('#previewpoto').show(); // Tampilkan elemen pratinjau foto
    }

    // Event change untuk input file Kop Surat
    $('input[id=poto').change(function () {
        var fileName = $(this).val().split('\\').pop();
        $('#SelectedFileNamepoto').val(fileName);
        $('#previewpoto').show(); // Tampilkan pratinjau foto saat dipilih
        readURL(this, '#previewpoto'); // Panggil fungsi readURL untuk menampilkan foto
    });

    
});

function readURL(input, imgSelector) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function (e) {
            $(imgSelector).attr('src', e.target.result); // Change image source
        }
        reader.readAsDataURL(input.files[0]);
    }
}
$(document).ready(function() {
        $('#changePasswordCheckbox').change(function() {
            if(this.checked) {
                $('#passwordFields').show();
            } else {
                $('#passwordFields').hide();
            }
        });
    });


    </script>