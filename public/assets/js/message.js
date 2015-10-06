/**
 * Create message with string msg
 * @param  string msg
 * @return boolean
 */
function message(msg) {
    if (window.confirm(msg)) {
        return true;
    }
    return false;
}
