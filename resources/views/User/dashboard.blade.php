@extends('Tamplate.main')

@section('title', 'Login')

@section('content')

    <h1 class="text-center">Parabens vc acabou de logar !</h1>

@if (isset($produtos->elements)):
    

    <div class="text-center justfy-conten-center">

        <table class="table">
            <thead>
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Nome</th>
                    <th scope="col">Descrição</th>
                    <th scope="col">Codigo externo</th>
                    <th scope="col"> Restrições alimentares</th>
                    <th scope="col"> Serie</th>
                    <th scope="col"> Quantidade</th>
                    <th scope="col"> Unidade</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($produtos->elements as $produto)
                    <tr>
                        <th scope="row">{{ $produto->id ?? "" }}</th>
                       
                        <td>{{$produto->name ?? ""}}</td>
                        <td>{{$produto->description ?? ""}}</td>
                        <td>{{$produto->externalCode ?? ""}}</td>
                        
                    </tr>
                @endforeach
            </tbody>
        </table>

    </div>

    @endif
@endsection
