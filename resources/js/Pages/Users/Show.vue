<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import ProfileCard from '../Shared/ProfileCard.vue';
import Empty from '../Shared/Empty.vue';
import { TabGroup, TabList, Tab, TabPanels, TabPanel } from '@headlessui/vue';
import SimplePagination from '../Shared/SimplePagination.vue';
import Card from '../Shared/Card.vue';
import Replies from '../Shared/Replies.vue';

let props = defineProps({
    profile: Object,
    posts: Object,
    replies: Object,
});

</script>
<template>
    <AppLayout title="User Profile">

        <div class="py-10 pl-4">
            <div class="mx-auto text-center">
                <ProfileCard :profile="profile" />
            </div>
        </div>

        <section>
            <TabGroup>
                <TabList class="text-center flex space-x-1 p-2 mx-4 rounded-lg">
                    <Tab v-slot="{ selected }" as="template">
                        <button :class="[selected ? 'btn btn-primary btn-sm' : 'btn btn-primary btn-sm btn-active']">
                             Posts
                        </button>
                    </Tab>
                    <Tab v-slot="{ selected }" as="template">
                        <button :class="[selected ? 'btn btn-primary btn-sm' : 'btn btn-primary btn-sm btn-active']">
                             Replies
                        </button>
                    </Tab>
                    <Tab v-slot="{ selected }" as="template">
                        <button :class="[selected ? 'btn btn-primary btn-sm' : 'btn btn-primary btn-sm btn-active']">
                             Votes
                        </button>
                    </Tab>
                </TabList>
                <TabPanels>
                    <TabPanel>

                        <Empty v-if="posts.meta.total === 0" />
                        <Card :posts="posts" />
                        <SimplePagination class="mb-6" v-if="posts.meta.total >= 11" :data="posts.links" />

                    </TabPanel>
                    <TabPanel>

                        <Empty v-if="replies.meta.total === 0" />
                        <Replies :replies="replies" />
                        <SimplePagination class="mb-6" v-if="replies.meta.total >= 11" :data="replies.links" />

                    </TabPanel>
                    <TabPanel>
                        <div class="px-4 mx-auto max-w-screen-xl lg:px-6">
                            <div class="mx-auto max-w-screen-sm text-center p-10">

                                Soon.

                            </div>
                        </div>
                    </TabPanel>
                </TabPanels>
            </TabGroup>

        </section>

    </AppLayout>
</template>