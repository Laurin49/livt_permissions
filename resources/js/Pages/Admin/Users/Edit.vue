<script setup>
import AdminLayout from "@/Layouts/AdminLayout.vue";
import InputError from "@/Components/InputError.vue";
import InputLabel from "@/Components/InputLabel.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import TextInput from "@/Components/TextInput.vue";
import { Head, Link, useForm } from "@inertiajs/vue3";
import Table from "@/Components/Table.vue";
import TableRow from "@/Components/TableRow.vue";
import TableDataCell from "@/Components/TableDataCell.vue";
import TableHeaderCell from "@/Components/TableHeaderCell.vue";

const props = defineProps({
  user: {
    type: Object,
    required: true,
  },
});

const form = useForm({
  name: props.user?.name,
  email: props.user?.email,
});

const submit = () => {
  form.put(route("users.update", props.user?.id));
};

</script>

<template>
  <AdminLayout>
    <Head title="Create user" />
    <div class="mx-auto mt-4 max-w-7xl">
      <div class="flex justify-between">
        <Link
          :href="route('users.index')"
          class="px-3 py-2 font-semibold text-white bg-indigo-500 rounded hover:bg-indigo-700"
          >Back</Link
        >
      </div>
    </div>
    <div class="max-w-6xl p-6 mx-auto mt-6 bg-slate-100">
      <form @submit.prevent="submit">
        <div class="mt-4">
          <InputLabel for="name" value="Name" />

          <TextInput
            id="name"
            type="text"
            class="block w-1/2 mt-1"
            v-model="form.name"
            required
            autofocus
            autocomplete="name"
          />

          <InputError class="mt-2" :message="form.errors.name" />
        </div>

        <div class="mt-4">
          <InputLabel for="email" value="Email" />

          <TextInput
            id="email"
            type="email"
            class="block w-1/2 mt-1"
            v-model="form.email"
            required
            autocomplete="username"
          />

          <InputError class="mt-2" :message="form.errors.email" />
        </div>

        <div class="flex items-center justify-start mt-4">
          <PrimaryButton
            :class="{ 'opacity-25': form.processing }"
            :disabled="form.processing"
          >
            Update User
          </PrimaryButton>
        </div>
      </form>
    </div>
  </AdminLayout>
</template>