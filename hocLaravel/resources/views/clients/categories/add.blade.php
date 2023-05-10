<h1>Them chuyen muc</h1>
<form action="<?php echo route('categories.add')?>" method="post">
    <div>
{{--        <input type="text" name="category_name" placeholder="Ten chuyen muc" value="{{$cateName}}">--}}
        <input type="text" name="category_name" placeholder="Ten chuyen muc"
               value="<?php echo old('category_name', 'Default'); ?>">
        <input type="text" name="id" placeholder="Ten chuyen muc">
        <input type="text" name="producer" placeholder="Ten chuyen muc">
<!--        <input type="hidden" name="_token" value="--><?php //echo csrf_token() ?><!--"> -->
        <?php echo csrf_field()?>
    </div>
    <button type="submit">Submit</button>

</form>
