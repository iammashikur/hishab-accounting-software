@php $editing = isset($expence) @endphp

<div class="flex flex-wrap">
    <x-inputs.group class="w-full">
        <x-inputs.select name="type" label="Type">
            @php $selected = old('type', ($editing ? $expence->type : '')) @endphp
            <option value="ঘর ভাড়া" {{ $selected == 'ঘর ভাড়া' ? 'selected' : '' }} >ঘর ভাড়া</option>
            <option value="বিদ্যুৎ বিল" {{ $selected == 'বিদ্যুৎ বিল' ? 'selected' : '' }} >বিদ্যুৎ বিল</option>
            <option value="ইন্টারনেট বিল" {{ $selected == 'ইন্টারনেট বিল' ? 'selected' : '' }} >ইন্টারনেট বিল</option>
            <option value="গ্যাস বিল" {{ $selected == 'গ্যাস বিল' ? 'selected' : '' }} >গ্যাস বিল</option>
            <option value="বাজার খরচ" {{ $selected == 'বাজার খরচ' ? 'selected' : '' }} >বাজার খরচ</option>
            <option value="কেনাকাটা" {{ $selected == 'কেনাকাটা' ? 'selected' : '' }} >কেনাকাটা</option>
            <option value="কাউকে দিন" {{ $selected == 'কাউকে দিন' ? 'selected' : '' }} >কাউকে দিন</option>
        </x-inputs.select>
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.textarea
            name="description"
            label="Description"

            >{{ old('description', ($editing ? $expence->description : ''))
            }}</x-inputs.textarea
        >
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.number
            name="amount"
            label="Amount"
            :value="old('amount', ($editing ? $expence->amount : ''))"

            step="0.01"
            placeholder="Amount"
            required
        ></x-inputs.number>
    </x-inputs.group>
</div>
