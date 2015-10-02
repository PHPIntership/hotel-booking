/**
 * Create messange with string msg
 * @param  string msg
 * @return boolean
 */
function messange(msg) {
    if (window.confirm(msg)) {
        return true;
    }
    return false;
}
