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
    <x-layout.header>

        @if(auth()->check())
            <a href="/profile" class="btn btn-primary" type="submit">{{session()->get("token");}}</a>
        @else
            <a href="/login" class="btn btn-warning" type="submit">Login</a>
        @endif
        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            Makanan
        </a>
        <ul class="dropdown-menu">
            @foreach($category->original as $key => $value)
                <li><a href={{"?category_id=".$value["id"]}} class="dropdown-item" >{{$value["category"]}}</a></li>
            @endforeach
        </ul>
    </x-layout.header>

    <div class="food-page">
    <h1 class="category">{{ $category->original["$category_id"]["category"] }}</h1>
    <div class="container row card_container">
        @foreach($products->original as $key => $value)
            <div class="col-md-3">
                <div class="col-md-3 card shadow-sm h-100" style="width: 100%;">
                    <img src={{$value["image"]}} class="card-img-top" alt="..." height="150px">
                    <div class="card-body">
                        <h5 class="card-title">{{$value["name"]}}</h5>
                        <p class="card-text"><?=substr($value["description"],0,140)?>...</p>
                        <form action="/api/orders/add/" method="GET">
                            @csrf
                            <input type="hidden" name="user_id" value={{auth()->id()}}>
                            <input type="hidden" name="food_id" value={{$value["id"]}}>
                            <input type="number" name="quantity" value="1" id="quantity">
                            <button type="submit" name="price" class="btn btn-primary" value={{$value["price"] * $value["piece"]}}>@if($value["piece"] <= 1) {{'$' . $value["price"]}} @else {{'$' . $value["price"] . "/" . $value["piece"] . " pcs"}} @endif</button>
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



.custom-select {
  position: relative;
  font-family: Arial;
}

.custom-select select {
  display: none; /*hide original SELECT element:*/
}

.select-selected {
  background-color: DodgerBlue;
}

/*style the arrow inside the select element:*/
.select-selected:after {
  position: absolute;
  content: "";
  top: 14px;
  right: 10px;
  width: 0;
  height: 0;
  border: 6px solid transparent;
  border-color: #fff transparent transparent transparent;
}

/*point the arrow upwards when the select box is open (active):*/
.select-selected.select-arrow-active:after {
  border-color: transparent transparent #fff transparent;
  top: 7px;
}

/*style the items (options), including the selected item:*/
.select-items div,.select-selected {
  color: #ffffff;
  padding: 8px 16px;
  border: 1px solid transparent;
  border-color: transparent transparent rgba(0, 0, 0, 0.1) transparent;
  cursor: pointer;
  user-select: none;
}

/*style items (options):*/
.select-items {
  position: absolute;
  background-color: DodgerBlue;
  top: 100%;
  left: 0;
  right: 0;
  z-index: 99;
}

/*hide the items when the select box is closed:*/
.select-hide {
  display: none;
}

.select-items div:hover, .same-as-selected {
  background-color: rgba(0, 0, 0, 0.1);
}
</style>