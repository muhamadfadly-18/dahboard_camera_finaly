<form id='create' action="" enctype="multipart/form-data" method="post" accept-charset="utf-8" class="needs-validation" novalidate>
    <b style="display: block;text-align: center; margin-bottom: 20px; font-size:20px;">USER</b>
    <fieldset class="form-group border p-3" style="box-shadow: 0 2px 5px rgba(0,0,0,0.2),-2px 0 5px rgba(0,0,0,0.2),  2px 0 5px rgba(0,0,0,0.2);margin-top:-17px;">
        <div id="status"></div>
        <div class="form-row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="id">ID</label>
                    <input type="id" class="form-control" id="id" name="id" value="" placeholder="Your id">
                    <span id="error_id" class="has-error"></span>
                </div>
                </div>
                <div class="col-md-6">
                <div class="form-group">
                    <label for="name">Name</label>
                    <input type="text" class="form-control" id="name" name="name" value="" placeholder="Your Name">
                    <span id="error_name" class="has-error"></span>
                </div>
            </div>
                
            
            {{-- <div class="col-md-6">
                <img id="previewpoto" class="mb-3" style="max-width: 200px; max-height: 200px; margin-top: 10px; display: none;">
                <div class="form-group text-center">
                    <label for="poto">Photo (File must be jpg, jpeg, png)</label>
                    <div class="input-group">
                        <input id="poto" type="file" name="poto" style="display:none">
                        <div class="input-group-prepend">
                            <a class="btn btn-secondary text-white" onclick="$('input[id=poto]').click();">Browse</a>
                        </div>
                        <input type="text" name="SelectedFileNamepoto" class="form-control" id="SelectedFileNamepoto" value="" readonly>
                    </div>
                    
                    <span id="error_poto" class="has-error"></span>
                </div>
            </div> --}}
        </div>
    </fieldset>     
    <div class="clearfix"></div>
    <div class="form-group col-md-12">
        <button type="submit" class="btn btn-success button-submit" data-loading-text="Loading..."><span class="fa fa-save fa-fw"></span> Save</button>
    </div>
</form>

<script>
    $('.button-submit').click(function () {
        // route name
        ajax_submit_store('worker')
    });
    // Function to display image preview for poto
    $('input[id=poto]').change(function () {
        var fileName = $(this).val().split('\\').pop();
        $('#SelectedFileNamepoto').val(fileName);
        $('#previewpoto').show(); // Show image preview when selected
        readURL(this, '#previewpoto'); // Call readURL function to display image
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
</script>
