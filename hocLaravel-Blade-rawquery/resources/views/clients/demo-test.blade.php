 <h2>DEMO VIEW UNICODE</h2>
    <form action="{{route('demoNe')}}" method="post">
        <input type="text" name="username" placeholder="Nhap username" value="{{old('username')}}">
        @csrf
        <button class="btn btn-success">Submit</button>
    </form>
    <?= session('type') ?>
    @if(session('mess'))
        <div class="alert alert-{{session('type')}}"> {{session('mess')}}</div>
    @endif

