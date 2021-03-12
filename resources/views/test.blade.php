<form action="/upload" method="post" enctype="multipart/form-data">
    @csrf
    <input type="file" name="img" id="">
    <button type="submit">submit</button>
</form>