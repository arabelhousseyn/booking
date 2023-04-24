<footer class="main-footer">
    <strong id="copyright">Copyright &copy; 2014-2019 </strong> All rights
    reserved.
</footer>

<script>
    let el = document.getElementById('copyright');
    el.innerHTML = ((new Date()).getFullYear() === 2023) ?
        `Copyright &copy; ${new Date().getFullYear()}`
        :
        `Copyright &copy; ${new Date().getFullYear()}-${new Date().getFullYear() + 1}`
</script>
