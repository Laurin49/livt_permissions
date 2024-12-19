<script setup>
import { ref } from "vue";
import AdminLayout from "@/Layouts/AdminLayout.vue";
import { Head, Link, useForm } from "@inertiajs/vue3";
import { usePermission } from "@/composables/permissions";
import Table from "@/Components/Table.vue";
import TableRow from "@/Components/TableRow.vue";
import TableHeaderCell from "@/Components/TableHeaderCell.vue";
import TableDataCell from "@/Components/TableDataCell.vue";
import Modal from "@/Components/Modal.vue";
import DangerButton from "@/Components/DangerButton.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";

defineProps(["posts"]);
const form = useForm({});

const showConfirmDeletePostModal = ref(false);
const currentDeleteId = ref(0);

const { hasPermission } = usePermission();

const confirmDeletePost = (id) => {
    showConfirmDeletePostModal.value = true;
    currentDeleteId.value = id;
};

const closeModal = () => {
    showConfirmDeletePostModal.value = false;
};

const deletePost = () => {
    form.delete(route("posts.destroy", currentDeleteId.value), {
        onSuccess: () => closeModal(),
    });
};
</script>

<template>
    <Head title="Posts Index" />

    <AdminLayout>
        <div class="py-4 mx-auto max-w-7xl">
            <div class="flex justify-between">
                <h1>Posts Index Page</h1>
                  <template v-if="hasPermission('Create Post')">
                    <Link
                        :href="route('posts.create')"
                        class="px-3 py-2 font-semibold text-white bg-indigo-500 rounded hover:bg-indigo-700"
                        >New Post</Link
                    >
                  </template>
            </div>
            <div class="mt-6">
                <Table>
                    <template #header>
                        <TableRow>
                            <TableHeaderCell>ID</TableHeaderCell>
                            <TableHeaderCell>Title</TableHeaderCell>
                            <TableHeaderCell>Action</TableHeaderCell>
                        </TableRow>
                    </template>
                    <template #default>
                        <TableRow
                            v-for="post in posts"
                            :key="post.id"
                            class="border-b"
                        >
                            <TableDataCell>{{ post.id }}</TableDataCell>
                            <TableDataCell>{{ post.title }}</TableDataCell>
                            <TableDataCell class="space-x-4">
                              <template v-if="hasPermission('Update Post')">
                                <Link
                                    :href="route('posts.edit', post.id)"
                                    class="text-green-400 hover:text-green-600"
                                    >Edit</Link
                                >
                              </template>
                              <template v-if="hasPermission('Delete Post')">
                                <button
                                    @click="confirmDeletePost(post.id)"
                                    class="text-red-400 hover:text-red-600"
                                >
                                    Delete
                                </button>
                              </template>
                                <Modal
                                    :show="showConfirmDeletePostModal"
                                    @close="closeModal"
                                >
                                    <div class="p-6">
                                        <h2
                                            class="text-lg font-semibold text-slate-800"
                                        >
                                            Are you sure to delete this Post?
                                        </h2>
                                        <div class="flex mt-6 space-x-4">
                                            <DangerButton
                                                @click="deletePost()"
                                                >Delete</DangerButton
                                            >
                                            <SecondaryButton @click="closeModal"
                                                >Cancel</SecondaryButton
                                            >
                                        </div>
                                    </div>
                                </Modal>
                            </TableDataCell>
                        </TableRow>
                    </template>
                </Table>
            </div>
        </div>
    </AdminLayout>
</template>
