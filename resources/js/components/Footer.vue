<template>
    <footer class="footer footer-fix">
        <div class="container-fluid">
        <div class="row">
            <div class="col-md-6 footer-copyright">
            <p class="mb-0">Copyright 2023 © Buildovate. All rights reserved.</p>
            </div>
            <div class="col-md-6">
            <p class="pull-right mb-0 pr-5">
                <Link href="/privacy-policy" name="Privacy Policy" icon=""></Link>&nbsp;|&nbsp;
                <Link href="/terms-of-service" name="Terms Of Service" icon=""></Link>
            </p>
            </div>
        </div>
        </div>
    </footer>
</template>

<script setup>

import Link from "@/components/Link.vue";

const footerLinks = [
    { name: 'Terms Of Service', href: '/terms-of-use' },
    { name: 'Privacy Policy', href: '/privacy-policy' }, 
    { name: 'Earnings Disclaimer', href: '/earnings-disclaimer' }, 
    { name: 'Anti Spam Policy', href: '/anti-spam-policy' }, 
    { name: 'Refund Policy', href: '/refund-policy' },
    { name: 'Subscription Cancellation Policy', href: '/subscription-cancellation-policy' }, 
    { name: 'Cookie Policy', href: '/cookie-policy' }, 
    // { name: 'Contact Us', href: 'mailto:suppport@slingly.com' },
]

</script>

<style>
.active{
    text-decoration: underline;
    color: green;
}
</style>
