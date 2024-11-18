@extends('template.master')

@section('content')
<div class="bg-[#f5f5f5] border border-[#f5f5f5] rounded p-3 flex flex-col overflow-y-scroll max-h-[598px]">
    <div class="flex flex-col items-center justify-center">
        <h3 class="font-bold text-2xl text-[#ff66c4]">¿QUÉ ES LA LEY KARIN?</h3>
        <p class="text-lg pt-6">La ley N°21.643 modifica el Código del Trabajo en materia de prevención, investigación y sanción del acoso laboral, sexual y violencia en el trabajo.
            <br>
            Establece diversas disposiciones que modifican e incorporan definiciones legales, añade medidas de prevención y resguardo en la materia y perfecciona 
            los procedimientos de investigación, implementando y adecuando la normativa nacional a los parámetros establecidos en el recientemente ratificado Convenio N°190, 
            Sobre la Violencia y el Acoso, de la Organización Internacional del Trabajo - OIT.
        </p>
    </div>

    <div class="flex flex-col items-center justify-center mt-8">
        <h3 class="font-bold text-2xl text-[#ff66c4]">CONCEPTOS CLAVES</h3>
        <img src="{{ asset('images/conceptos.png') }}" alt="conceptos" class="text-lg pt-6"></img>
    </div>

    <div class="flex gap-6 mt-6 w-full items-center justify-between">
        <div class="flex flex-col items-start gap-1">
            <p>Para realizar una denuncia, favor contactarse con el correo: </p>
            <span href="#" class="text-[#ff66c4] font-bold">gonzalezcontreras.fp@gmail.com</span>
        </div>
        <div class="flex items-center gap-6">
            <p>Para más información sobre la Ley</p>
            <a href="https://www.bcn.cl/leychile/navegar?idNorma=1200096%20" class="rounded-lg bg-[#ff66c4] text-white px-6 py-2" target="_blank">Pincha aquí</a>
        </div>
    </div>
</div>
@endsection