<template>
  <div class=" bg-gray custom-rounded">
    <div class="pt-2">
      <ul class="nav nav-tabs" role="tablist" style="border-bottom: none !important;">
        <li class="nav-item" v-for="(tab, index) in tabs" :key="index">
          <a 
            class="nav-link p-2" 
            :class="{ active: activeTab === tab.event }" 
            data-toggle="tab" 
            href="#" 
            role="tab" 
            @click.prevent="activeTab = tab.event"
            style="font-size: 14px !important;"
          >
            <i :class="tab.icon" class="mx-0"></i> {{ tab.name }}
          </a>
        </li>
      </ul>
    </div>

    <!-- Tab panes -->
    <div class="tab-content bg-gray p-3 m-0">
      <!-- All Form -->
      <div class="tab-pane fade bg-gray" :class="{ 'show active': activeTab === 'all' }" role="tabpanel">

        <div style="background-color: white;" class="custom-rounded p-4 m-2 mx-0">
          <form>
            <div class="form-group row px-2">
              <input type="email" class="form-control col bg-gray" placeholder="To:" />
              <input type="text" class="form-control col bg-gray" placeholder="Subject:" />
            </div>
            <div class="form-group pb-0 mb-0">
              <textarea class="form-control bg-gray" rows="6" placeholder="Your message"></textarea>
            </div>
            <div class="d-flex justify-content-between">
              <div class="form-group">
                <button type="button" class="btn p-2">B</button>
                <button type="button" class="btn p-2">I</button>
                <button type="button" class="btn p-2">U</button>
                <button type="button" class="btn p-2">•••</button>
                <button type="button" class="btn p-2">@</button>
              </div>
              <div class="form-group ml-auto pt-1">
                <button type="submit" class="btn btn-primary-v2">Send Mail</button>
              </div>
            </div>
          </form>
        </div>
      </div>
      <!-- NOTES Form -->
      <div class="tab-pane fade" :class="{ 'show active': activeTab === 'notes' }" role="tabpanel">
        <div style="background-color: white;" class="custom-rounded p-4 m-2 mx-0">
          <form>
            <div class="form-group row px-2">
              <select name="noteType" id="noteType" class="form-control bg-gray" style="background-image: default;text-indent: 0;">
                <option value="1" selected disabled hidden>Select note type</option>
              </select>
            </div>
            <div class="form-group pb-0 mb-0">
              <textarea class="form-control bg-gray" rows="6" placeholder="Add note or type @name to notify"></textarea>
            </div>
            <div class="d-flex justify-content-between">
              <div class="form-group">
                <button type="button" class="btn p-2">B</button>
                <button type="button" class="btn p-2">I</button>
                <button type="button" class="btn p-2">U</button>
                <button type="button" class="btn p-2">•••</button>
                <button type="button" class="btn p-2">@</button>
              </div>
              <div class="form-group ml-auto pt-1">
                <button type="submit" class="btn btn-primary-v2">Send Mail</button>
              </div>
            </div>
          </form>
        </div>
      </div>
      
      <!-- EMAILS Form -->
      <div class="tab-pane fade" :class="{ 'show active': activeTab === 'emails' }" role="tabpanel">
        <div style="background-color: white;" class="custom-rounded p-4 m-2 mx-0">
          <form>
            <div class="form-group row px-2">
              <input type="email" class="form-control col bg-gray" placeholder="To:info@buildovate.com" />
            </div>
            <div class="form-group row px-2">
              <input type="text" class="form-control col bg-gray" placeholder="Subject:" />
            </div>
            <div class="form-group pb-0 mb-0">
              <textarea class="form-control bg-gray" rows="6" placeholder="Start Typing..."></textarea>
            </div>
            <div class="d-flex justify-content-between">
              <div class="form-group">
                <button type="button" class="btn p-2">B</button>
                <button type="button" class="btn p-2">I</button>
                <button type="button" class="btn p-2">U</button>
                <button type="button" class="btn p-2">•••</button>
                <button type="button" class="btn p-2">@</button>
              </div>
              <div class="form-group ml-auto pt-1">
                <button type="submit" class="btn btn-primary-v2">Send Mail</button>
              </div>
            </div>
          </form>
        </div>
      </div>

      <!-- MESSAGES Form -->
      <div class="tab-pane fade" :class="{ 'show active': activeTab === 'messages' }" role="tabpanel">
        <div style="background-color: white;" class="custom-rounded p-4 m-2 mx-0">
          <form>
            <div class="form-group row px-2">
              <input type="email" class="form-control col bg-gray" placeholder="To:info@buildovate.com" />
            </div>
            <div class="form-group row px-2">
              <input type="email" class="form-control col bg-gray" placeholder="From:" />
            </div>
            <div class="form-group pb-0 mb-0">
              <textarea class="form-control bg-gray" rows="6" placeholder="Start Typing..."></textarea>
            </div>
            <div class="d-flex justify-content-between">
              <div class="form-group">
                <button type="button" class="btn p-2">B</button>
                <button type="button" class="btn p-2">I</button>
                <button type="button" class="btn p-2">U</button>
                <button type="button" class="btn p-2">•••</button>
                <button type="button" class="btn p-2">@</button>
              </div>
              <div class="form-group ml-auto pt-1">
                <button type="submit" class="btn btn-primary-v2">Send Mail</button>
              </div>
            </div>
          </form>
        </div>
      </div>
      
      <!-- CALLS Form -->
      <div class="tab-pane fade" :class="{ 'show active': activeTab === 'calls' }" role="tabpanel">
        <div style="background-color: white;" class="custom-rounded p-4 m-2 mx-0">
          <form>
            <div class="form-group row px-2">
              <input type="email" class="form-control col bg-gray" placeholder="To:info@buildovate.com" />
            </div>
            <div class="form-group row px-2">
              <input type="email" class="form-control col bg-gray" placeholder="From:" />
            </div>
            <div class="form-group pb-0 mb-0">
              <textarea class="form-control bg-gray" rows="6" placeholder="Start Typing..."></textarea>
            </div>
            <div class="d-flex justify-content-between">
              <div class="form-group">
                <button type="button" class="btn p-2">B</button>
                <button type="button" class="btn p-2">I</button>
                <button type="button" class="btn p-2">U</button>
                <button type="button" class="btn p-2">•••</button>
                <button type="button" class="btn p-2">@</button>
              </div>
              <div class="form-group ml-auto pt-1">
                <button type="submit" class="btn btn-primary-v2">Send Mail</button>
              </div>
            </div>
          </form>
        </div>
      </div>

      <!-- CHECKLIST Form -->
      <div class="tab-pane fade" :class="{ 'show active': activeTab === 'checklist' }" role="tabpanel">
        <div style="background-color: white;" class="custom-rounded p-4 m-2 mx-0">
          <form>
            <div class="form-group row px-2">
              <input type="email" class="form-control col bg-gray" placeholder="To:info@buildovate.com" />
            </div>
            <div class="form-group row px-2">
              <input type="email" class="form-control col bg-gray" placeholder="From:" />
            </div>
            <div class="form-group pb-0 mb-0">
              <textarea class="form-control bg-gray" rows="6" placeholder="Start Typing..."></textarea>
            </div>
            <div class="d-flex justify-content-between">
              <div class="form-group">
                <button type="button" class="btn p-2">B</button>
                <button type="button" class="btn p-2">I</button>
                <button type="button" class="btn p-2">U</button>
                <button type="button" class="btn p-2">•••</button>
                <button type="button" class="btn p-2">@</button>
              </div>
              <div class="form-group ml-auto pt-1">
                <button type="submit" class="btn btn-primary-v2">Send Mail</button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: 'TabbedComponent',
  data() {
    return {
      activeTab: 'all',
      tabs: [
        { name: 'All', event: 'all', icon: 'icon-menu', content: 'Content for All' },
        { name: 'Notes', event: 'notes', icon: 'icon-notepad', content: 'Content for Notes' },
        { name: 'Emails', event: 'emails', icon: 'icon-email', content: 'Content for Emails' },
        { name: 'Messages', event: 'messages', icon: 'icon-comment', content: 'Content for Messages' },
        { name: 'Calls', event: 'calls', icon: 'icon-headphone-alt', content: 'Content for Calls' },
        { name: 'Jobsite Checklist', event: 'checklist', icon: 'icofont icofont-check-circled', content: 'Content for Checklist' }
      ]
    }
  }
}
</script>

<style scoped>
/* Add additional styling if needed */

  /* Add custom styles if needed to match the uploaded image */
  .form-group.row input {
    margin-right: .5rem;
  }
  .form-group textarea {
    margin-top: 1rem;
  }
  .btn-light {
    margin-right: .5rem;
  }
  .btn-primary {
    margin-top: 1rem;
  }

  
.nav-tabs .nav-link {
  border: none !important;
  color: #000000 !important;
  font-size: 14px !important;
}

.nav-tabs .nav-link:hover {
  border: none !important;
}

.nav-tabs .nav-link.active {
  color: rgb(255, 255, 255) !important;
  font-weight: bold !important;
  background-color: #1e5bb2 !important;
  border: 1px solid !important;
  border-radius: 10px;
  padding-left: 15px;
  padding-top: 0px;
}
.nav-tabs {
  border-bottom: 1px solid #b3b4b6 !important;
}
</style>
