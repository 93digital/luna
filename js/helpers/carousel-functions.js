export const setupPrevNextBtns = (prevBtn, nextBtn, embla) => {
  if (prevBtn !== null) {
    prevBtn.addEventListener('click', embla.scrollPrev, false);
  }
  if (nextBtn !== null) {
    nextBtn.addEventListener('click', embla.scrollNext, false);
  }
};

export const disablePrevNextBtns = (prevBtn, nextBtn, embla) => {
  return () => {
    if (prevBtn !== null) {
      if (embla.canScrollPrev()) {
        prevBtn.removeAttribute('disabled');
      } else {
        prevBtn.setAttribute('disabled', 'disabled');
      }
    }

    if (nextBtn !== null) {
      if (embla.canScrollNext()) {
        nextBtn.removeAttribute('disabled');
      } else {
        nextBtn.setAttribute('disabled', 'disabled');
      }
    }
  };
};
