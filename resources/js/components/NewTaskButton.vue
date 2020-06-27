<template>
    <div class="p-3">
        <button class="rounded text-white"  

style="background-color: #150658;"><b>Add New Task</b></button>
    </div>
</template>

<script>
    export default {
        mounted() {
            name: 'newtaskbutton'
            console.log('Component mounted.')
        }
    }
</script>

<style>
    .newtaskbutton {
        background-color: #0000FF;
    }

   .rounded{
       border-radius: 0.85rem !important;
   }
</style>