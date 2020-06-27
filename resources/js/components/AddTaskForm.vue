<template>
  <form
    class="mb-3 overflow-hidden"
    @submit.prevent="handleAddNewTask"
  >
    <div class="p-3 flex-1">
      <input
        class="block px-2 py-1 rounded"
        type="text"
        placeholder="Enter a title"
        v-model.trim="newTask.title"
      />
      </div>
      <div class="p-3 flex-1" style="padding-top: 0rem !important;">
      <textarea
        class="mt-3 p-2 block p-1 rounded"
        rows="2"
        placeholder="Add a description (optional)"
        v-model.trim="newTask.description"
      ></textarea>
      </div>
      <div v-show="errorMessage">
        <span class="text-xs text-red-500">
          {{ errorMessage }}
        </span>
      </div>
    </div>
    <div class="p-3">
      <button
        @click="$emit('task-canceled')"
        type="reset"
        class="py-1 text-pink rounded"
      >
        cancel
      </button>
      <button
        type="submit"
        class="px-3 py-1 text-pink rounded"
      >
        Add
      </button>
    </div>
  </form>
</template>

<script>
export default {
  props: {
    statusId: Number
  },
  data() {
    return {
      newTask: {
        title: "",
        description: "",
        status_id: null
      },
      errorMessage: ""
    };
  },
  mounted() {
    this.newTask.status_id = this.statusId;
  },
  methods: {
    handleAddNewTask() {
      // Basic validation so we don't send an empty task to the server
      if (!this.newTask.title) {
        this.errorMessage = "The title field is required";
        return;
      }

      // Send new task to server
      axios
        .post("/tasks", this.newTask)
        .then(res => {
          // Tell the parent component we've added a new task and include it
          this.$emit("task-added", res.data);
        })
        .catch(err => {
          // Handle the error returned from our request
          this.handleErrors(err);
        });
    },
    handleErrors(err) {
      if (err.response && err.response.status === 422) {
        // We have a validation error
        const errorBag = err.response.data.errors;
        if (errorBag.title) {
          this.errorMessage = errorBag.title[0];
        } else if (errorBag.description) {
          this.errorMessage = errorBag.description[0];
        } else {
          this.errorMessage = err.response.message;
        }
      } else {
        // We have bigger problems
        console.log(err.response);
      }
    }
  }
};
</script>
<style>

.text-pink {
  background-color: #ff00344f;
  border-color: #dca6ba52;
}

.rounded{
  border-radius: 0.85rem !important;
}
</style>