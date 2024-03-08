@php $editing = isset($loan) @endphp

<div class="flex flex-wrap">
    <x-inputs.group class="w-full">
        <x-inputs.text
            name="source"
            label="Source"
            :value="old('source', ($editing ? $loan->source : ''))"

            placeholder="Source"
            required
        ></x-inputs.text>
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.textarea
            name="description"
            label="Description"

            >{{ old('description', ($editing ? $loan->description : ''))
            }}</x-inputs.textarea
        >
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.number
            name="amount"
            label="Amount"
            :value="old('amount', ($editing ? $loan->amount : ''))"

            step="0.01"
            placeholder="Amount"
            required
        ></x-inputs.number>
    </x-inputs.group>
</div>
