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
    <h1 class="category">{{ $category->original["category"] }}</h1>
    <div class="container row card_container">
        @foreach($products->original as $key => $value)
            <div class="col-md-3">
                <div class="col-md-3 card shadow-sm h-100" style="width: 100%;">
                    <img src={{$value["image"]}} class="card-img-top" alt="..." height="150px">
                    <div class="card-body">
                        <h5 class="card-title">{{$value["name"]}}</h5>
                        <p class="card-text"><?=substr($value["description"],0,140)?>...</p>
                        <form action="/order/{{$value["id"]}}" method="GET">
                            @csrf
                            <input type="number" name="quantity" value="1" id="quantity">
                            <input type="submit" name="order" class="btn btn-primary" value="@if($value["piece"] <= 1) {{'$' . $value["price"]}} @else {{'$' . $value["price"] . "/" . $value["piece"] . " pcs"}} @endif">
                        </form>

                    </div>
                </div>
            </div>
            @endforeach
        </div>

    </div>




    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>
    <script>
        
    </script>
</body>
</html>

<style>
body{
    background: #afa;
}
.food-page{
    text-align: center;
    padding: 15px;

    position: relative;
    /* display: flex;
    justify-content: center; */
}
.container{
    position: absolute;
    left: 50%;
    transform: translate(-50%);
}

.category{
    margin-top: 10px;
    margin-bottom: 25px;
}

#quantity{
    width: 40px;
}

</style>