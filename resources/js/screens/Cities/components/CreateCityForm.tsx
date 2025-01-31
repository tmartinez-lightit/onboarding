import { zodResolver } from "@hookform/resolvers/zod";
import { useMutation } from "@tanstack/react-query";
import { useForm } from "react-hook-form";

import {
  createCityQuery,
  handleAxiosFieldErrors,
  upsertCityPayloadSchema,
  type UpsertCityPayloadSchema,
} from "~/api";
import { Button, errorToast, Input, TOAST_TYPES, useToastStore } from "~/ui";

interface CreateCityFormProps {
  onSuccess: () => void;
}

export const CreateCityForm = ({ onSuccess }: CreateCityFormProps) => {
  const { pushToast } = useToastStore();

  const {
    register,
    reset,
    handleSubmit,
    setError,
    formState: { errors },
  } = useForm<UpsertCityPayloadSchema>({
    resolver: zodResolver(upsertCityPayloadSchema),
    mode: "onTouched",
  });

  const { mutate: createCityMutation } = useMutation({
    mutationFn: createCityQuery.mutation,
    onSuccess: () => {
      onSuccess();
      reset();
      void pushToast({
        type: TOAST_TYPES.success,
        title: "Success",
        message: "City created successfully",
      });
    },
    onError: (error) => {
      handleAxiosFieldErrors(error, setError);
      errorToast(error);
    },
  });

  const handleCreateCitySubmit = (data: UpsertCityPayloadSchema) => {
    createCityMutation(data);
  };

  return (
    <form onSubmit={handleSubmit(handleCreateCitySubmit)} className="space-y-4">
      <Input
        id="name"
        label="City Name"
        placeholder="Enter city name"
        type="text"
        {...register("name")}
        error={errors.name?.message}
      />

      <div className="flex justify-end">
        <Button type="submit">Add City</Button>
      </div>
    </form>
  );
};
