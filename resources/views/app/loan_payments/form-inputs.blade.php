@php $editing = isset($loanPayment) @endphp

<div class="flex flex-wrap">
    <x-inputs.group class="w-full">
        <x-inputs.select name="loan_id" label="Loan" required>
            @php $selected = old('loan_id', ($editing ? $loanPayment->loan_id : '')) @endphp
            <option disabled {{ empty($selected) ? 'selected' : '' }}>Please select the Loan</option>
            @foreach($loans as $value => $label)
            <option value="{{ $value }}" {{ $selected == $value ? 'selected' : '' }} >{{ $label }}</option>
            @endforeach
        </x-inputs.select>
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.number
            name="amount"
            label="Amount"
            :value="old('amount', ($editing ? $loanPayment->amount : ''))"

            step="0.01"
            placeholder="Amount"
            required
        ></x-inputs.number>
    </x-inputs.group>
</div>
