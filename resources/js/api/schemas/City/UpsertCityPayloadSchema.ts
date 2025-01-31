import { z } from "zod";

export const upsertCityPayloadSchema = z.object({
  name: z.string().min(1, "City name is required"),
});

export type UpsertCityPayloadSchema = z.infer<typeof upsertCityPayloadSchema>;
