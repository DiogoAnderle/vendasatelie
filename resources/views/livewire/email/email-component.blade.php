<div>
    <x-card cardTitle="Criar novo Email">
        <x-slot:cardTools>
            <a href="{{ route('home') }}" class="btn btn-primary"><i class="fas fa-arrow-circle-left"></i> Voltar</a>
        </x-slot>
        <form wire:submit.prevent="saveEmail">
            <div class="col-lg-12 col-md-12 col-sm-12">
                <div class="card card-primary card-outline">
                <div class="card-body">
                        <div class="form-group">
                        <label for="subject" class="message">Assunto:</label>
                        <input wire:model.lazy="subject" id="subject" class="form-control" placeholder="Assunto:">
                        @error('subject')
                        <span class="text-red mt-0"><small><strong>*{{ $message }}</strong></small></span>
                        @enderror    
                </div>
                   
                    <div class="form-group">
                        <label for="message" class="message">Mensagem:</label>
                        <textarea wire:model.lazy="message" id="message" class="form-control" style="height: 150px"></textarea>
                        @error('message')
                        <span class="text-red mt-0"><small><strong>*{{ $message }}</strong></small></span>
                    @enderror
                    </div>
                </div>

                <div class="card-footer">
                    <div class="float-right">
                    <button type="submit" class="btn btn-primary"><i class="far fa-envelope"></i> Enviar</button>
                    </div>
                </div>

                </div>

            </div>
        </form>


    </x-card>

 </div>
