<script setup>
import AdminLayout from "@/Layouts/AdminLayout.vue";
import { Head, Link, useForm } from "@inertiajs/vue3";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import InputLabel from "@/Components/InputLabel.vue";
import InputError from "@/Components/InputError.vue";
import TextInput from "@/Components/TextInput.vue";
import { onMounted } from "vue";

const props = defineProps({
  role: {
    type: Object,
    required: true,
  },
});
const form = useForm({
  name: props.role.name,
});

onMounted(() => {
});

</script>

<template>
  <Head title="Update role" />

  <AdminLayout>
    <div class="py-4 mx-auto max-w-7xl">
      <div class="flex justify-between">
        <Link
          :href="route('roles.index')"
          class="px-3 py-2 font-semibold text-white bg-indigo-500 rounded hover:bg-indigo-700"
          >Back
        </Link>
      </div>
      <div class="max-w-6xl p-6 mx-auto mt-6 rounded-lg shadow-lg bg-slate-100">
        <h1 class="text-2xl font-semibold text-indigo-700">Update role</h1>
        <form @submit.prevent="form.put(route('roles.update', role.id))">
          <div class="mt-4">
            <InputLabel for="name" value="Name" />
            <TextInput
              id="name"
              type="text"
              class="block w-full mt-1"
              v-model="form.name"
              autofocus
            />
            <InputError class="mt-2" :message="form.errors.name" />
          </div>
          
          <div class="flex items-center mt-4">
            <PrimaryButton
              :class="{ 'opacity-25': form.processing }"
              :disabled="form.processing"
            >
              Update
            </PrimaryButton>
          </div>
        </form>
      </div>
    </div>
  </AdminLayout>
</template>