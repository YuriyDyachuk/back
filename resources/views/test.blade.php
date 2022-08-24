<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

    <title>Success Verified!</title>
    <style>
        .alert-arrow {
            border: 1px solid #60c060;
            color: #54a754;
        }
        .alert-arrow .alert-icon {
            position: relative;
            width: 3rem;
            background-color: #60c060;
        }
        .alert-arrow .alert-icon::after {
            content: "";
            position: absolute;
            width: 0;
            height: 0;
            border-top: .75rem solid transparent;
            border-bottom: .75rem solid transparent;
            border-left: .75rem solid #60c060;
            right: -.75rem;
            top: 50%;
            transform: translateY(-50%);
        }
        .alert-arrow .close {
            font-size: 1rem;
            color: #cacaca;
        }
    </style>
</head>
<body>
<div class="alert alert-arrow d-flex rounded p-0" role="alert">
    <div class="alert-icon d-flex justify-content-center align-items-center text-white flex-grow-0 flex-shrink-0">
        <i class="fa fa-check"></i>
    </div>
    <div class="alert-message d-flex align-items-center py-2 pl-4 pr-3">
        Информационное сообщение, содержащее некоторый текст. Это сообщение можно закрыть.
    </div>
    <a href="#" class="close d-flex ml-auto justify-content-center align-items-center px-3" data-dismiss="alert">
        <i class="fas fa-times"></i>
    </a>
</div>
<!-- Optional JavaScript -->
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>
</html>
