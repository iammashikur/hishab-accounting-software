@php $editing = isset($earning) @endphp

<div class="flex flex-wrap">
    <x-inputs.group class="w-full">
        <x-inputs.select name="source" label="Source">
            @php $selected = old('source', ($editing ? $earning->source : '')) @endphp
            <option value="বেতন" {{ $selected == 'বেতন' ? 'selected' : '' }} >বেতন</option>
            <option value="আউট-সোর্সিং" {{ $selected == 'আউট-সোর্সিং' ? 'selected' : '' }} >আউট-সোর্সিং</option>
            <option value="অন্যান্য" {{ $selected == 'অন্যান্য' ? 'selected' : '' }} >অন্যান্য</option>
        </x-inputs.select>
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.textarea
            name="description"
            label="Description"

            >{{ old('description', ($editing ? $earning->description : ''))
            }}</x-inputs.textarea
        >
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.number
            name="amount"
            label="Amount"
            :value="old('amount', ($editing ? $earning->amount : ''))"

            step="0.01"
            placeholder="Amount"
            required
        ></x-inputs.number>
    </x-inputs.group>
</div>
