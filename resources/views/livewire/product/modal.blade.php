  <x-modal modalId="modalProduct" modalTitle="{{ $Id == 0 ? 'Criar Produto' : 'Editar Produto' }}" modalSize="modal-lg">
      <form wire:submit={{ $Id == 0 ? 'store' : "update($Id)" }}>
          <div class="form-row">
              {{-- Input Name --}}
              <div class="form-group col-md-7">
                  <label for="name" class="form-label">Produto:</label>
                  <input wire:model='name' type="text" class="form-control"id="name" placeholder="Nome do Produto">
                  @error('name')
                     <span class="text-danger"><small><strong>* {{ $message }}</strong></small></span>
                  @enderror
              </div>
              {{-- Select Category --}}
              <div class="form-group col-md-5">
                  <label for="category_id" class="form-label">Categoria:</label>
                  <select wire:model='category_id' type="text" class="form-control" id="category_id"
                      placeholder="Nome do Produto">
                      <option value="0">-- Selecione uma categoria --</option>
                      @foreach ($this->categories as $category)
                          <option value="{{ $category->id }}">{{ $category->name }}</option>
                      @endforeach


                  </select>
                  @error('category_id')
                     <span class="text-danger"><small><strong>* {{ $message }}</strong></small></span>
                  @enderror
              </div>
              {{-- TextArea Description --}}
              <div class="form-group col-md-12">
                  <label for="description" class="form-label">Descrição:</label>
                  <textarea rows="3" wire:model='description' type="text" class="form-control"
                      id="description"placeholder="Descrição do Produto"></textarea>
                  @error('description')
                  <span class="text-danger"><small><strong>* {{ $message }}</strong></small></span>
                  @enderror
              </div>

              {{-- Input Purchase Price --}}
              <div class="form-group col-md-6">
                  <label for="purchase_price" class="form-label">Preço de Compra:</label>
                  <input wire:model='purchase_price' type="number" min="0" step="any"
                      class="form-control"id="purchase_price" placeholder="Nome do Produto">
                  @error('purchase_price')
                     <span class="text-danger"><small><strong>* {{ $message }}</strong></small></span>
                  @enderror
              </div>

              {{-- Input Sale Price --}}
              <div class="form-group col-md-6">
                  <label for="sale_price" class="form-label">Preço de Venda:</label>
                  <input wire:model='sale_price' type="number" min="0" step="any"
                      class="form-control"id="sale_price" placeholder="Nome do Produto">
                  @error('sale_price')
                     <span class="text-danger"><small><strong>* {{ $message }}</strong></small></span>
                  @enderror
              </div>

              {{-- Input Stock --}}
              <div class="form-group col-md-6">
                  <label for="stock" class="form-label">Estoque:</label>
                  <input wire:model='stock' type="number" min="0" class="form-control"id="stock"
                      placeholder="Estoque">
                  @error('stock')
                     <span class="text-danger"><small><strong>* {{ $message }}</strong></small></span>
                  @enderror
              </div>

              {{-- Input Min Stock --}}
              <div class="form-group col-md-6">
                  <label for="min_stock" class="form-label">Estoque Mínimo:</label>
                  <input wire:model='min_stock' type="number" min="0" class="form-control"id="min_stock"
                      placeholder="Nome do Produto">
                  @error('min_stock')
                     <span class="text-danger"><small><strong>* {{ $message }}</strong></small></span>
                  @enderror
              </div>

              {{-- Checkbox Active --}}
              <div class="form-group col-md-3">
                  <div class="icheck-primary">
                      <input wire:model='active' checked type="checkbox" id="active">
                      <label for="active" class="form-label">Ativo</label>
                  </div>
              </div>

              {{-- Input Imagem --}}
              <div class="form-group col-md-3">
                  <label for="image" class="form-label">Imagem</label>
                  <input wire:model='image' type="file" id="image" accept="image/*">
                  @error('image')
                     <span class="text-danger"><small><strong>* {{ $message }}</strong></small></span>
                  @enderror
              </div>

              <div class="form-group col-md-6">
                  @if ($Id > 0)
                      <x-image :item="$product = App\Models\Product::find($Id)" size="200" float="float-right" />
                  @endif
                  {{-- Imagem --}}

                  @if ($this->image)
                      <img src="{{ $image->temporaryUrl() }}" class="rounded float-right" width="200">
                  @endif
              </div>

          </div>
          <button wire:loading-attr="disabled" class="btn btn-primary float-right">{{ $Id == 0 ? 'Salvar' : 'Editar' }}
          </button>
      </form>
  </x-modal>
