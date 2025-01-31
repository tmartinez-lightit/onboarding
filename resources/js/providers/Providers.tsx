import type { PropsWithChildren } from "react";
import React from "react";

import { Toasts } from "~/ui";
import { ReactQueryProvider } from "./ReactQueryProvider";
import { SentryProvider } from "./sentry/SentryProvider";

export const Providers = ({ children }: PropsWithChildren) => {
  return (
    <ReactQueryProvider>
      <SentryProvider>{children}</SentryProvider>
      <Toasts />
    </ReactQueryProvider>
  );
};
