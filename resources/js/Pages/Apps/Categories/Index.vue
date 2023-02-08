<template>
    <Head>
        <title>Categories - Aplikasi Kasir</title>
    </Head>

    <LayoutApp>
        <main class="c-main">
            <div class="container-fluid">
                <div class="fade-in">
                    <div class="row">
                        <div class="col-md-12">
                            <div
                                class="card border-0 rounded-3 shadow border-top-purple"
                            >
                                <div class="card-header">
                                    <span class="font-weight-bold"
                                        ><i class="fa fa-folder"></i>
                                        CATEGORIES</span
                                    >
                                </div>
                                <div class="card-body">
                                    <form @submit.prevent="handleSearch">
                                        <div class="input-group mb-3">
                                            <Link
                                                href="/apps/categories/create"
                                                v-if="
                                                    hasAnyPermission([
                                                        'categories.create',
                                                    ])
                                                "
                                                class="btn btn-primary input-group-text"
                                            >
                                                <i
                                                    class="fa fa-plus-circle me-2"
                                                ></i>
                                                NEW</Link
                                            >
                                            <input
                                                type="text"
                                                class="form-control"
                                                placeholder="search by category name..."
                                                v-model="search"
                                            />

                                            <button
                                                class="btn btn-primary input-group-text"
                                                type="submit"
                                            >
                                                <i
                                                    class="fa fa-search me-2"
                                                ></i>
                                                SEARCH
                                            </button>
                                        </div>
                                    </form>
                                    <table
                                        class="table table-striped table-bordered table-hover"
                                    >
                                        <thead>
                                            <tr>
                                                <th scope="col">Name</th>
                                                <th scope="col">Image</th>
                                                <th
                                                    scope="col"
                                                    style="width: 20%"
                                                >
                                                    Actions
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr
                                                v-for="(
                                                    category, index
                                                ) in categories.data"
                                                :key="index"
                                            >
                                                <td>{{ category.name }}</td>
                                                <td class="text-center">
                                                    <img
                                                        :src="category.image"
                                                        width="40"
                                                    />
                                                </td>
                                                <td class="text-center">
                                                    <Link
                                                        :href="`/apps/categories/${category.id}/edit`"
                                                        v-if="
                                                            hasAnyPermission([
                                                                'categories.edit',
                                                            ])
                                                        "
                                                        class="btn btn-success btn-sm me-2"
                                                        ><i
                                                            class="fa fa-pencil-alt me-1"
                                                        ></i>
                                                        EDIT</Link
                                                    >
                                                    <button
                                                        v-if="
                                                            hasAnyPermission([
                                                                'categories.delete',
                                                            ])
                                                        "
                                                        class="btn btn-danger btn-sm"
                                                        @click.prevent="destroy(categories.id)"
                                                    >
                                                        <i
                                                            class="fa fa-trash"
                                                        ></i>
                                                        DELETE
                                                    </button>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <Pagination
                                        :links="categories.links"
                                        align="end"
                                    />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </LayoutApp>
</template>

<script setup>
import { Head, Link } from '@inertiajs/inertia-vue3';
import LayoutApp from "../../../Layouts/App.vue";
import Pagination from "../../../Components/Pagination.vue";
import { ref } from 'vue';
import { Inertia } from '@inertiajs/inertia';
import Swal from 'sweetalert2';

const props = defineProps({
  categories: Object
});

const search = ref("" || (new URL(document.location).searchParams.get("q")));
const handleSearch = () => Inertia.get("/apps/categories", { q: search.value });

const destroy = (categoryID) => {
  Swal.fire({
    title: 'Are you sure?',
    text: "You won't be able to revert this!",
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: 'Yes, delete it!'
  })
  .then(result => {
    if (result.isConfirmed) {
      Inertia.delete(`/apps/categories/${categoryID}`);
      Swal.fire({
        title: 'Deleted!',
        text: 'Category deleted successfully.',
        icon: 'success',
        timer: 2000,
        showConfirmButton: false,
      });
    }
  })
}
</script>