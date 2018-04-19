/**
 * Creates and returns a new, throttled version of the passed
 *  function, that, when invoked repeatedly, will only actually
 *  call the original function at most once per every 'threshold'
 *  milliseconds. Useful for rate-limiting events that occur
 *  faster than you can keep up with.
 * @link - https://remysharp.com/2010/07/21/throttling-function-calls
 */
export default function throttle(fn, threshhold = 250, scope) {
    let last;
    let deferTimer;

    return function (...args) {
        const context = scope || this;
        const now = +new Date();
        if (last && now < last + threshhold) {
            // hold on to it
            clearTimeout(deferTimer);
            deferTimer = setTimeout(() => {
                last = now;
                fn.apply(context, args);
            }, threshhold);
        } else {
            last = now;
            fn.apply(context, args);
        }
    };
}

