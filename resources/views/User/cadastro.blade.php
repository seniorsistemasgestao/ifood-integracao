@extends('Tamplate.main')

@section('title', 'Cadastro de credencial')

@section('content')

    <section class="ftco-section">
        
        <div class="container">
            
            <div class="row justify-content-center">
                <div class="col-md-6 text-center mb-5">
        
                    @if (Session::has('msg-error'))
                    <div class="container-fluid" style="justify-content: center;" id="card-alert">
                        <div class="container" style="">
            
                            <div class="alert alert-danger" id="danger">
                                {{ Session::get('msg-error') }}
                            </div>
                        </div>
                    </div>
                @endif
            
            
                @if (Session::has('msg-success'))
                    <div class="container-fluid" style="justify-content: center;" id="card-alert">
                        <div class="container" style="">
            
                            <div class="alert alert-success" id="succes">
                                {{ Session::get('msg-success') }}
                            </div>
                        </div>
                    </div>
                @endif
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="col-md-12 col-lg-10">
                    <div class="wrap d-md-flex">
                        <div class="text-wrap p-4 p-lg-5 text-center d-flex align-items-center order-md-last">
                            <div class="text w-100">
                                <h2>Bem vindo ao Cadastro</h2>
                                <p>Já tem login? faça login agora mesmo.</p>
                                <a href="/" class="btn btn-white btn-outline-white">Login</a>
                            </div>
                        </div>
                        <div class="login-wrap p-4 p-lg-5">
                            <div class="d-flex">
                                <div class="w-100">
                                    <h3 class="mb-4">Cadastro de Credencias</h3>
                                </div>
                             {{-- 
                             
                             <div class="w-100">
                                    <p class="social-media d-flex justify-content-end">
                                        <a href="#"
                                            class="social-icon d-flex align-items-center justify-content-center"><span
                                                class="fa fa-facebook"></span></a>
                                        <a href="#"
                                            class="social-icon d-flex align-items-center justify-content-center"><span
                                                class="fa fa-twitter"></span></a>
                                    </p>
                                </div>
                             --}}
                            </div>
                            <form   method="POST" action="{{ route('post.cadastro')}}"  class="signin-form">
                                @csrf
                                <div class="form-group mb-3">
                                    <label class="label" for="name">Emai</label>
                                    <input type="text" name="email" class="form-control" placeholder="Email"
                                        value="{{ old('email') }}" required>
                                </div>
                                <div class="form-group mb-3">
                                    <label class="label" for="password">Senha</label>
                                    <input type="password" name="password"  class="form-control" placeholder="password"
                                        value="{{ old('password') }}" required>
                                </div>
                                <div class="form-group mb-3">
                                    @error('password')
                                        <span class="danger text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="form-group mb-3">
                                    <label class="label" for="cliente_id">Cliente ID</label>
                                    <input type="text" name="cliente_id" class="form-control" placeholder="Cliente ID"
                                        value="{{ old('cliente_id') }}" required>
                                </div>
                                <div class="form-group mb-3">
                                    @error('cliente_id')
                                        <span class="danger text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="form-group mb-3">
                                    <label class="label" for="cliente_secreto">Cliente Secreto</label>
                                    <input type="text" name="cliente_secreto" class="form-control" placeholder="Cliente Segredo"
                                        value="{{ old('cliente_secreto') }}" required>
                                </div>
                                <div class="form-group mb-3">
                                    @error('cliente_sereto')
                                        <span class="danger text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="form-group mb-3">
                                    <label class="label" for="mercado_id">Mercado ID</label>
                                    <input type="text" name="mercado_id" class="form-control" placeholder="Mercado ID"
                                        value="{{ old('mercado_id') }}" required>
                                </div>
                                <div class="form-group mb-3">
                                    @error('mercado_id')
                                        <span class="danger text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <button type="submit" class="form-control btn btn-primary submit px-3">Cadastrar</button>
                                </div>
                                <div class="form-group d-md-flex">
                                    {{--  
                                    <div class="w-50 text-left">
                                        <label class="checkbox-wrap checkbox-primary mb-0">Remember Me
                                            <input type="checkbox" checked>
                                            <span class="checkmark"></span>
                                        </label>
                                    </div>
                                    --}}
            
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>






@endsection
@push('javascript')
    <script src="{{ asset('js/ocultar.js') }}"></script>
    <script src="{{ asset('js/alert.js') }}"></script>
@endpush
