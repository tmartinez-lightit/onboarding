import React from "react";
import { BrowserRouter } from "react-router-dom";

import { SystemRouter } from "~/domains";

export const Router = () => {
  return (
    <BrowserRouter>
      <SystemRouter />
    </BrowserRouter>
  );
};
