   <div class="flex flex-col">
       <label for="{{ $id }}" class="font-medium text-gray-700">{{ $label }}</label>
       <select name="{{ $id }}" id="{{ $id }}" class="select w-full mt-3" required>
           <option value="">Pilih</option>
           @foreach ($data as $key => $option)
               <option value="{{ $key }}" {{ $value && $key == $value ? 'selected' : '' }}>{{ $option }}
               </option>
           @endforeach
       </select>
   </div>
