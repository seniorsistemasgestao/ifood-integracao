@extends('Tamplate.main')

@section('title', 'Login')

@section('content')

    <h1 class="text-center">Parabens vc acabou de logar !</h1>

    @if (isset($produtos->elements)):


        <h1>Produtos cadastrados {{$produtos->count}}</h1> 
        {{-- dd($produtos->elements) --}}
        <div class="text-center container container-fluid justfy-conten-center">

            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Nome</th>
                        <th scope="col">Descrição</th>
                        <th scope="col">Codigo externo</th>
                        <th scope="col"> Informações adicionais</th>
                        <th scope="col"> Serie</th>
                        <th scope="col"> Quantidade</th>
                        <th scope="col"> Unidade</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($produtos->elements as $produto)
                        <tr>
                            <th scope="row">{{ $produto->id ?? 'Não informado' }}</th>

                            <td>{{ $produto->name ?? 'Não informado' }}</td>
                            <td>{{ $produto->description ?? 'Não informado' }}</td>
                            <td>{{ $produto->externalCode ?? 'Não informado' }}</td>
                            <td>{{ $produto->additionalInformation ?? 'Não informado' }}</td>
                            <td>{{ $produto->ean ?? 'Não informado' }}</td>
                            <td>{{ $produto->weight->quantity ?? 'Não informado' }}</td>
                            <td>{{ $produto->weight->unit ?? 'Não informado' }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

        </div>

    @endif
@endsection
