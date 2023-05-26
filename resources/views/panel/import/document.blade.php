@extends('layouts.app')
 
@section('content')
    <div class="center-align">
        <h5>Importaçāo de dados</h5>

        <a class="waves-effect waves-light btn-large btn-process-document">Processar Documentos</a>
    </div>
@endsection

@push('scripts')
    <script type="text/javascript">
        $(document).ready(function() {
            $('.btn-process-document').click(function() {
                var $this = $(this)

                $this.addClass('disabled');

                axios.get('/api/import/document')
                    .then(function (response) {
                        M.toast({html: `${response.data.processed} documentos do exercicio ${response.data.year} processados com sucesso!`});
                    })
                    .catch(function (response) {
                        M.toast({html: 'Ocorreu um erro inesperado na solicitaçāo'});

                        console.error(response);
                    })
                    .finally(function (response) {
                        $this.removeClass('disabled');
                    });
            });
        });
    </script>
@endpush
