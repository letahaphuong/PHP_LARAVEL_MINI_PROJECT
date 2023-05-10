<h1>Upload file</h1>
<form action="<?php echo route('categories.upload') ?>" method="post" enctype="multipart/form-data">
    <div>
        <input type="file" name="photo">
        <?php echo csrf_field() ?>
    </div>
    <button type="submit">Upload</button>

</form>
