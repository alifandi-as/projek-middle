<?php
    use Illuminate\Support\Facades\Session;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href={{asset('/assets/css/app.css')}}>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
</head>
<body>
    <x-layout.header/>
    <div class="food-page">
    <h1>{{ $category->original["category"] }}</h1>
    @foreach($products->original as $key => $value)
        <div class="container row card_container">
            <div class="col-md-4">
                <div class="col-md-4 card shadow-sm h-100" style="width: 100%;">
                    <img src={{$value["image"]}} class="card-img-top" alt="..." height="150px">
                    <div class="card-body">
                        <h5 class="card-title">{{$value["name"]}}</h5>
                        <p class="card-text"><?=substr($value["description"],0,140)?>...</p>
                        <a href="/view/?product_id={{$value["id"]}}" class="btn btn-primary">{{'$' . $value["price"]}}</a>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
    </div>




    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>
</body>
</html>

<style>
.food-page{
    text-align: center;
    padding: 15px;
    background: #afa;
}

</style>