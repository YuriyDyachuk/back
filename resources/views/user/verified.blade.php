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
        .body {
            overflow: hidden;
        }
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
        .center {
            position:absolute;top:50%;
        }
        /* danger */
        .alert-arrow-danger {
            border: 1px solid #da4932;
            color: #ca452e;
        }

        .alert-arrow-danger .alert-icon {
            background-color: #da4932;
        }

        .alert-arrow-danger .alert-icon::after {
            border-left: .75rem solid #da4932;
        }
    </style>
</head>
<body>
<div class="container-fluid h-100" style="margin-top:20%;">
    <div class="row align-items-center h-100">
        <div class="col-sm-12">
            <div class="row justify-content-center">
                <div class="text-center">
                    @if($success)
                    <div class="alert alert-arrow d-flex rounded p-0" role="alert">
                        <div class="alert-icon d-flex justify-content-center align-items-center text-white flex-grow-0 flex-shrink-0">
                            <i class="fa fa-check"></i>
                        </div>
                        <div class="alert-message d-flex align-items-center py-2 pl-4 pr-3">
                            Акаунт успішно підтверджений
                        </div>
                        <a href="#" class="close d-flex ml-auto justify-content-center align-items-center px-3" data-dismiss="alert">
                        </a>
                    </div>
                    @else


                    <div class="alert alert-arrow alert-arrow-danger d-flex rounded p-0" role="alert">
                        <div class="alert-icon d-flex justify-content-center align-items-center text-white flex-grow-0 flex-shrink-0">
                            <i class="fas fa-times-circle"></i>
                        </div>
                        <div class="alert-message d-flex align-items-center py-2 pl-4 pr-3">
                            Сталася помилка. Спробуйте ще раз пізніше
                        </div>
                        <a href="#" class="close d-flex ml-auto justify-content-center align-items-center px-3" data-dismiss="alert">

                        </a>
                    </div>
                    @endif


                </div>
            </div>
        </div>
    </div>
</div>




<!-- Optional JavaScript -->
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>
</html>
