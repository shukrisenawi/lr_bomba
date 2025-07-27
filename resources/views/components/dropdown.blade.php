   <div class="flex flex-col">
       @php
           $id = strval($id);
           $value = strval($value);
       @endphp
       <label for="{{ $id }}" class="font-medium text-gray-700">{{ $label }}</label>
       <select name="{{ $id }}" id="{{ $id }}" class="select w-full mt-3" required>
           <option>Pilih</option>
           @foreach ($data as $key => $option)
               <option value="{{ $key }}" {{ $value && $key == $value ? 'selected' : '' }}>{{ $option }}
               </option>
           @endforeach
       </select>
   </div>
   @if (is_string($id))
       @error($id)
           <div style="color: red;">{{ $message }}</div>
       @enderror
   @endif
