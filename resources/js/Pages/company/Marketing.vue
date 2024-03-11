<template>
<div class="container-fluid">
        <div class="row">
                <div class="col-sm-12 col-xl-12 xl-100">
                <div class="card">
                        <!-- <div class="card-header pb-0">
                        <h5>Tabs Vertical</h5>
                        </div> -->
                        <div class="card-body">
                        <div class="row">
                        <div class="col-sm-3 col-xs-12">
                                <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                                        <a v-for="tab in tabMenus" :key="tab.name"
                                                :class="(tab.target=='MarketingCalendar') ? 'nav-link active' : 'nav-link' " 
                                                :id="tab.target+'-tab'" 
                                                data-bs-toggle="pill" 
                                                :href="'#'+tab.target"
                                                role="tab" 
                                                :aria-controls="tab.target" 
                                                :aria-selected="(tab.target=='MarketingCalendar') ? true : false">
                                                {{ tab.name }}
                                        </a>
                                        <!--                                         
                                        <a class="nav-link active" id="v-pills-home-tab" data-bs-toggle="pill" href="#v-pills-home" role="tab" aria-controls="v-pills-home" aria-selected="true">Home</a>
                                        <a class="nav-link" id="v-pills-profile-tab" data-bs-toggle="pill" href="#v-pills-profile" role="tab" aria-controls="v-pills-profile" aria-selected="false">Profile</a>
                                        <a class="nav-link" id="v-pills-messages-tab" data-bs-toggle="pill" href="#v-pills-messages" role="tab" aria-controls="v-pills-messages" aria-selected="false">Messages</a>
                                        <a class="nav-link" id="v-pills-settings-tab" data-bs-toggle="pill" href="#v-pills-settings" role="tab" aria-controls="v-pills-settings" aria-selected="false">Settings</a> -->
                                </div>
                        </div>
                        <div class="col-sm-9 col-xs-12">
                                <div class="tab-content" id="v-pills-tabContent">

                                        <div v-for="tab in tabMenus" :key="tab.name"
                                                :class="(tab.target=='MarketingCalendar') ? 'tab-pane fade show active' : 'tab-pane fade'" 
                                                :id="tab.target" 
                                                role="tabpanel" 
                                                :aria-labelledby="tab.target+'-tab'">
                                                
                                                <MarketingCalendar v-if="tab.target=='MarketingCalendar'"/>
                                                <BuyLeads v-if="tab.target=='BuyLeads'"/>
                                                <AutoImportLeads v-if="tab.target=='AutoImportLeads'" :fb_app_id="fb_app_id" :hasFBToken="hasFBToken"/>
                                                <EmailMarketing v-if="tab.target=='EmailMarketing'"/>
                                                <OrganicInstagramGrowth v-if="tab.target=='OrganicInstagramGrowth'"/>
                                                <ReviewManagement v-if="tab.target=='ReviewManagement'"/>
                                                <LocalGoogleRankings v-if="tab.target=='LocalGoogleRankings'"/>
                                                <ListingManagement v-if="tab.target=='ListingManagement'"/>
                                                <BrandedMagazines v-if="tab.target=='BrandedMagazines'"/>
                                                <HandwrittenLetters v-if="tab.target=='HandwrittenLetters'"/>
                                                <Reports v-if="tab.target=='Reports'"/>
                                        </div>

                                        <!-- <div class="tab-pane fade show active" id="v-pills-home" role="tabpanel" aria-labelledby="v-pills-home-tab">
                                                <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s</p>
                                        </div>
                                        <div class="tab-pane fade" id="v-pills-profile" role="tabpanel" aria-labelledby="v-pills-profile-tab">
                                                <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum</p>
                                        </div>
                                        <div class="tab-pane fade" id="v-pills-messages" role="tabpanel" aria-labelledby="v-pills-messages-tab">
                                                <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum</p>
                                        </div>
                                        <div class="tab-pane fade" id="v-pills-settings" role="tabpanel" aria-labelledby="v-pills-settings-tab">
                                                <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum</p>
                                        </div> -->
                                </div>
                        </div>
                        </div>
                        </div>
                </div>
                </div>
        </div>
</div>
</template>

<script setup>
defineProps(['fb_app_id','hasFBToken']);

import MarketingCalendar from "@/Pages/company/marketing/MarketingCalendar.vue";
import BuyLeads from "@/Pages/company/marketing/BuyLeads.vue";
import AutoImportLeads from "@/Pages/company/marketing/AutoImportLeads.vue";
import EmailMarketing from "@/Pages/company/marketing/EmailMarketing.vue";
import OrganicInstagramGrowth from "@/Pages/company/marketing/OrganicInstagramGrowth.vue";
import ReviewManagement from "@/Pages/company/marketing/ReviewManagement.vue";
import LocalGoogleRankings from "@/Pages/company/marketing/LocalGoogleRankings.vue";
import ListingManagement from "@/Pages/company/marketing/ListingManagement.vue";
import BrandedMagazines from "@/Pages/company/marketing/BrandedMagazines.vue";
import HandwrittenLetters from "@/Pages/company/marketing/HandwrittenLetters.vue";
import Reports from "@/Pages/company/marketing/Reports.vue";

const tabMenus = [
                { name: 'Marketing Calendar', target: 'MarketingCalendar', icon: '' }, 
                { name: 'Buy Leads', target: 'BuyLeads', icon: '' },
                { name: 'Auto-Import Leads', target: 'AutoImportLeads', icon: '' },
                { name: 'Email Marketing', target: 'EmailMarketing', icon: '' },
                { name: 'Organic Instagram Growth', target: 'OrganicInstagramGrowth', icon: '' },
                { name: 'Review Management', target: 'ReviewManagement', icon: '' },
                { name: 'Local Google Rankings', target: 'LocalGoogleRankings', icon: '' },
                { name: 'Listing Management', target: 'ListingManagement', icon: '' },
                { name: 'Branded Magazines', target: 'BrandedMagazines', icon: '' },
                { name: 'Handwritten Letters', target: 'HandwrittenLetters', icon: '' },
                { name: 'Reports', target: 'Reports', icon: '' },
        ];

</script>

        