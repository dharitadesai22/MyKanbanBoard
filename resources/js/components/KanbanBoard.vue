<template>
    <div class="p-2 h-full">
    <!-- Columns (Statuses) -->
    <div
      v-for="status in statuses"
      :key="status.slug"
      class="p-2"
      style="width:400px;"
    >
   
      <div class="overflow-hidden">
        <div class="p-3  bg-blue-800 bd-1">
          <h4 class="font-medium text-white">
           <b> {{ status.title }} </b>
          </h4>
        </div>
       
        <div class="p-2 bg-blue-100">

          <!-- AddTaskForm -->
          <AddTaskForm
            v-if="newTaskForStatus === status.id"
            :status-id="status.id"
            v-on:task-added="handleTaskAdded"
            v-on:task-canceled="closeAddTaskForm"
          />
          <!-- ./AddTaskForm -->

          <!-- Tasks -->
          <draggable
            class="flex-1"
            v-model="status.tasks"
            v-bind="taskDragOptions"
            @end="handleTaskMoved"
          >
            <transition-group
              class="h-full overflow-x-hidden overflow-y-auto rounded shadow-xs"
              tag="div"
            >
              <div
                v-for="task in status.tasks"
                :key="task.id"
                class="mb-3 p-4 flex flex-col bg-white rounded-md shadow transform hover:shadow-md cursor-pointer bd-1"
              >
              <b>
                <span class="h1 block mb-2 text-xl text-blue1">
                 <b> {{ task.title }} </b>
                </span> 
                </b>
                <p class="text-purple">
                  {{ task.description }}
                </p>
                 <button
                   @click="openAddTaskForm(status.id)"
                   class="text-pink rounded"
                  >
                    Add
                 </button>
          
              </div>
              <!-- ./Tasks -->
            </transition-group>
          </draggable>
          <!-- No Tasks -->
          <div
            v-show="!status.tasks.length && newTaskForStatus !== status.id"
            class="p-4 justify-center"
          >
            <span class="text-purple">No tasks yet</span>
            <button
              class="text-pink rounded"
              @click="openAddTaskForm(status.id)"
            >
              Add One
            </button>
          </div>
          <!-- ./No Tasks -->
        </div>
      </div>
    </div>
    <!-- ./Columns -->
  </div>
</template>

<script>
import draggable from "vuedraggable";
import AddTaskForm from "./AddTaskForm";

export default {
  components: { draggable, AddTaskForm },
  props: {
    initialData: Array
  },
  data() {
    return {
      statuses: [],

      newTaskForStatus: 0
    };
  },
  computed: {
    taskDragOptions() {
      return {
        animation: 200,
        group: "task-list",
        dragClass: "status-drag"
      };
    }
  },
  mounted() {
    // 'clone' the statuses so we don't alter the prop when making changes
    this.statuses = JSON.parse(JSON.stringify(this.initialData));
  },
  methods: {
    openAddTaskForm(statusId) {
      this.newTaskForStatus = statusId;
    },
    closeAddTaskForm() {
      this.newTaskForStatus = 0;
    },
    handleTaskAdded(newTask) {
      // Find the index of the status where we should add the task
      const statusIndex = this.statuses.findIndex(
        status => status.id === newTask.status_id
      );

      // Add newly created task to our column
      this.statuses[statusIndex].tasks.push(newTask);

      // Reset and close the AddTaskForm
      this.closeAddTaskForm();
    },
    handleTaskMoved(evt) {
      axios.put("/tasks/sync", { columns: this.statuses }).catch(err => {
        console.log(err.response);
      });
    }
  }
};
</script>

<style scoped>
.status-drag {
  transition: transform 0.5s;
  transition-property: all;
}

.bg-blue-800 {
  background-color:#150658
}

.bd-1{
  border-radius: 10px
}

.h1{
  font-size: 1.50rem
}

.text-blue1{
  color: #15accc;
}

.text-purple{
  color: #e86ee5;
}

.text-pink {
  background-color: #ff00344f;
  border-color: #dca6ba52;
}
.rounded{
  border-radius: 0.85rem !important;
}
</style>
