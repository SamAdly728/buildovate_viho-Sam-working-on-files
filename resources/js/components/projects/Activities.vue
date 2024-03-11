<template>
<div class="activities-container  bg-gray">
  <div class="activity-wrapper" v-for="(activity, index) in activities" :key="activity.id">
      <div class="activity-icon m-1">
        <div class="rounded-circle px-2 py-1" style="background-color: #A2C5F6;"><i :class="activity.icon"></i></div>
        <!-- Only add a vertical line if this is not the last item -->
        <div v-if="index < activities.length - 1" class="vertical-line"></div>
      </div>
      
      <div class="activity-main">
        <div class="activity-header">
          <img :src="activity.image" class="rounded-circle profile-image" alt="Profile image">
          <div class="activity-info">
            <span class="activity-title">{{ activity.title }}</span>
            <p> <span class="activity-date">{{ activity.date }}</span> </p>
          </div>
          <div class="activity-actions rounded-3 p-2" style="font-size: 12px !important; background-color: white;">
            <a href="#" class="reply-action"><i class="fa fa-reply" style="font-size: 12px !important;"></i> Reply</a>
            <span class="text-muted"> | </span>
            <a href="#" class="more-actions"><i class="fa fa-ellipsis-h" style="font-size: 12px !important;"></i></a>
          </div>
        </div>
        
        <div class="activity-content">
          <h6 class="activity-heading">{{ activity.heading }}</h6>
          <p>{{ activity.body }}</p>
          <a href="#" class="view-email">View email</a>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      activities: [
        {
          id: 1,
          icon: 'fa fa-envelope fa-outline',
          image: '/assets/images/user/4.jpg',
          title: 'Sales > Dev Team',
          date: 'Nov 1',
          heading: 'Big news from follow up boss',
          body: 'Hello, Dev! Thank you so much for being a follow up boss customer, as you know from your own.',
        },
        {
          id: 2,
          icon: 'fa fa-phone fa-outline',
          image: '/assets/images/user/5.jpg',
          title: 'Support > Client Query',
          date: 'Nov 2',
          heading: 'Follow up on support ticket',
          body: 'Hi Dev, just reaching out to update you on your recent support ticket.',
        },
        {
          id: 3,
          icon: 'fa fa-comment fa-outline',
          image: '/assets/images/user/6.jpg',
          title: 'HR > Dev Team',
          date: 'Nov 3',
          heading: 'New HR Policies',
          body: 'Please make sure to read through the new HR policies by the end of the week.',
        },
      ]
    };
  }
}
</script>

<style scoped>

.activities-container {
  /* This will contain all the activities */
  margin-bottom: 20px; /* Adjust as needed */
}

.activity-wrapper {
  /* display: flex;
  align-items: flex-start;
  background-color: #fff;
  padding: 16px;
  border-radius: 16px;
  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
  margin-bottom: 8px;
  position: relative; */

  display: flex;
  align-items: flex-start;
  margin-bottom: 30px; /* Adjust based on your design */
}

.activity-icon {
  font-size: 24px;
  color: #007bff;
  position: relative;
  padding-right: 16px;
}

.vertical-line {
  /* position: absolute;
  left: 50%;
  transform: translateX(-50%);
  top: 100%;
  bottom: -15px;
  border-left: 2px solid #8a8f95; */

  position: absolute;
  left: 31%; /* Center the line */
  transform: translateX(-50%);
  top: 100%; /* Start at the middle of the icon */
  height: calc(100% + 180px); /* Height should be the full height of the activity-wrapper plus the space to the next icon */
  border-left: 2px solid #8a8f95; /* The vertical line */
}

.activity-main {
  flex-grow: 1;
  margin-left: 16px; /* Adjust as needed */
  padding-top: 8px; /* Adjust based on your design */
}

.activity-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  width: 100%;
}

.activity-info {
  flex-grow: 1;
}

.profile-image {
  width: 40px;
  height: 40px;
  object-fit: cover;
  border-radius: 50%;
  margin-right: 16px;
}

.activity-title {
  font-weight: bold;
}

.activity-date {
  font-size: 0.875rem;
  color: #666;
}

.activity-actions {
  display: flex;
  align-items: center;
}

.activity-actions a {
  text-decoration: none;
  /* color: #007bff; */
  margin-left: 16px;
}

.activity-content {
  margin-top: 8px;
}

.activity-heading {
  font-size: 1rem;
  color: #333;
  margin-bottom: 8px;
}

.view-email {
  color: #007bff;
  text-decoration: none;
  font-weight: bold;
}

.activity-icon:last-child .vertical-line {
  display: none;
}
.fa {
  font-size: 22px;
}
.fa-outline {
  -webkit-text-stroke: 2px white; /* Define the width and color of the outline */
  color: transparent; /* Make the fill color transparent */
}
</style>
